<?php

namespace App\Console\Commands;

use App\User;
use App\Journal;
use App\Entry;
use App\Invite;
use App\Comment;
use App\Mail\ReportStatisticsMailable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReportStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:stats
                                {email=bmizepatterson@gmail.com : The email recipient of the report}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a report of site statistics';

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
        // Gather data
        $report = new \stdClass;

        // Meta data
        $report->meta = new \stdClass;
        $report->meta->date = now();

        // Environment data
        $report->environment = new \stdClass;
        $report->environment->level = config('app.env');
        $report->environment->url = config('app.url');

        // Totals
        $report->total = new \stdClass;
        $report->total->users = User::all()->count();
        $report->total->journals = Journal::all()->count();
        $report->total->entries = Entry::all()->count();
        $report->total->comments = Comment::all()->count();
        $report->total->invites = Invite::all()->count();

        // Send a mailable
        Mail::to($this->argument('email'))->send(new ReportStatisticsMailable($report));
        Log::debug('Site statistics sent to <' . $this->argument('email') . '>.');
        $this->info('[' . now() . ']: Report Statistics command complete');
    }
}
