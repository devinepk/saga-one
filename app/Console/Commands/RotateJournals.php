<?php

namespace App\Console\Commands;

use App\Journal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RotateJournals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journals:rotate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rotate any journals due for rotation';

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
        $expired_journals = Journal::where('next_change', '<=', now())->get();

        if ($expired_journals->count()) {
            Log::debug('Rotating journals...');

            $expired_journals->each(function ($journal) {

                $journal->sendTurnHasEndedNotification();
                $journal->rotate();
                // We have to reload the relationship since it has changed in the DB
                $journal->load('current_user');
                $journal->sendTurnHasStartedNotification();

                Log::debug("--Journal \"{$journal->title}\" rotated to {$journal->current_user->name}.");
            });

            Log::debug('Rotation complete. ' . $expired_journals->count() .' journal(s) rotated.');

        } else {
            Log::debug('No journals due for rotation.');
        }

        $this->info('[' . now() . ']: ' . $expired_journals->count() .' journal(s) rotated.');
    }
}
