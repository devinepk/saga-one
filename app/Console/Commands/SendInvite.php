<?php

namespace App\Console\Commands;

use App\Invite;
use App\Journal;
use App\User;
use Illuminate\Console\Command;

class SendInvite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:invite
                                {--invite= : The id of the invite}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a sample journal invite notification';

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
        } elseif (env('APP_ENV' !== 'production')) {
            // Make, but don't save, a mock invite from a mock user to a mock journal
            $invite = factory(Invite::class)->make();
            $invite->journal = factory(Journal::class)->make();
            $invite->sender = factory(User::class)->make();
        } else {
            $this->error('Cannot create mock invite in production. Use --invite=INVITE to pass an existing journal as an argument.');
        }

        if ($invite) {
            $invite->sendInviteNotification();
            $this->info("Invite sent to {$invite->email}.");
        }
    }
}
