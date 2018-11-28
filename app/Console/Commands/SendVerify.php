<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;

class SendVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:verify
                                {--user= : The id of the user recipient of the email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a sample email verification notification';

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
        $user = null;

        if ($id = $this->option('user')) {
            $user = User::find($id);

            if (blank($user)) {
                $this->error('Unable to find user with id ' . $id);
            }
        } elseif (App::environment('production')) {
            $this->error('Cannot create mock user in production. Use --user=USER to pass an existing user as an argument.');
        } else {
            // Create a mock user
            $user = factory(User::class)->create();
        }

        if ($user) {
            $user->sendEmailVerificationNotification();
            $this->info("Verification email sent to {$user->name} at {$user->email}.");
        }
    }
}
