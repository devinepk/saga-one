<?php

namespace App\Console\Commands;

use App\Invite;
use App\Journal;
use App\User;
use App\Notifications\InviteDeclined;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class SendInviteDeclined extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:invitedeclined
                                {--invite= : The id of the invte that was declined}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a sample invite declined notification';

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
            // Make, but don't save, a mock invite, journal, invited user, and sender
            $invite = factory(Invite::class)->make();
            $invite->journal = factory(Journal::class)->make();
            $invite->user = factory(User::class)->make();
            $invite->sender = factory(User::class)->make();
        }

        if ($invite) {
            $invite->sender->notify(new InviteDeclined($invite));
            $this->info("Invite declined notification for journal \"{$invite->journal->title}\" sent to {$invite->sender->name}.");
        }
    }
}
