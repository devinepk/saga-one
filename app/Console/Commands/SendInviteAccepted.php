<?php

namespace App\Console\Commands;

use App\Invite;
use App\Journal;
use App\User;
use App\Notifications\InviteAccepted;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class SendInviteAccepted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:inviteaccepted
                                {--invite= : The id of the invte that was accepted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a sample invite accepted notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $invite = null;

        if ($id = $this->option('invite')) {
            $invite = Invite::find($id);

            if (blank($invite)) {
                $this->error('Unable to find invite with id ' . $id);
            }
        } elseif (App::environment('production')) {
            $this->error('Cannot create mock invite in production. Use --invite=INVITE to pass an existing journal as an argument.');
        } else {
            // Create a mock invite, journal, invited user, and sender
            $users = factory(User::class, 2)->create();

            $journal = factory(Journal::class)->make();
            $journal->current_user()->associate($users[0]->id);
            $journal->creator()->associate($users[0]->id);
            $journal->next_change = now()->addSeconds($journal->period);
            $journal->save();

            $invite = factory(Invite::class)->make();
            $invite->journal()->associate($journal->id);
            $invite->user()->associate($users[1]->id);
            $invite->sender()->associate($users[0]->id);
            $invite->save();
        }

        if ($invite) {
            $invite->sender->notify(new InviteAccepted($invite));
            $this->info("Invite accepted notification for journal \"{$invite->journal->title}\" sent to {$invite->sender->name}.");
        }
    }
}
