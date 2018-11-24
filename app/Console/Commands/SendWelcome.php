<?php

namespace App\Console\Commands;

use App\User;
use App\Mail\UserWelcomeMailable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWelcome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:welcome
                                {--user= : The id of the user recipient of the email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a sample welcome email';

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
        } elseif (env('APP_ENV') !== 'production') {
            $user = factory(User::class)->make();
        } else {
            $this->error('Cannot create mock user in production. Use --user=USER to pass an existing user as an argument.');
        }

        if ($user) {
            Mail::to($user)->send(new UserWelcomeMailable($user));
            $this->info("Welcome email sent to {$user->name} at {$user->email}.");
        }
    }
}
