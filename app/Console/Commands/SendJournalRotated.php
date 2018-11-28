<?php

namespace App\Console\Commands;

use App\User;
use App\Journal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class SendJournalRotated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:journalrotated
                                {--journal= : The id of the journal that rotated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a sample journal rotated notification';

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
        $journal = null;

        if ($id = $this->option('journal')) {
            $journal = Journal::find($id);

            if (blank($journal)) {
                $this->error('Unable to find journal with id ' . $id);
            }
        } elseif (App::environment('production')) {
            $this->error('Cannot create mock journal in production. Use --journal=JOURNAL to pass an existing journal as an argument.');
        } else {
            // Create a mock journal and a mock user
            $journal = factory(Journal::class)->make();
            $user = factory(User::class)->create();
            $journal->current_user()->associate($user->id);
            $journal->creator()->associate($user->id);
            $journal->next_change = now()->addSeconds($journal->period);
            $journal->save();
        }

        if ($journal) {
            $journal->sendTurnNotification();
            $this->info("Rotation notification email for journal \"{$journal->title}\" sent to {$journal->current_user->name} at {$journal->current_user->email}.");
        }
    }
}
