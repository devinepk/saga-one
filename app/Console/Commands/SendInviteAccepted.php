<?php

namespace App\Console\Commands;

use App\Invite;
use App\Journal;
use App\User;
use App\Notifications\InviteAccepted;
use Illuminate\Console\Command;

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
                return;
            }
        } else {
            // Make, but don't save, a mock invite, journal, invited user, and sender
            $invite = factory(Invite::class)->make();
            $invite->journal = factory(Journal::class)->make();
            $invite->user = factory(User::class)->make();
            $invite->sender = factory(User::class)->make();
        }

        $invite->sender->notify(new InviteAccepted($invite));
        $this->info("Invite accepted notification for journal \"{$invite->journal->title}\" sent to {$invite->sender->name}.");
    }
}
