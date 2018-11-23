<?php

namespace App\Console\Commands;

use App\Journal;
use Illuminate\Console\Command;

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

        $expired_journals->each(function ($journal) {
            $journal->rotate();
            $journal->sendTurnNotification();
            // TODO: Trigger event
        });

        $this->info('[' . now() . ']: ' . $expired_journals->count() .' journal(s) rotated.');
    }
}
