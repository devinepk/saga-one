<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportStatisticsMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $report;

    /**
     * Create a new message instance.
     *
     * @param stdClass $report to display in the email
     * @return void
     */
    public function __construct($report)
    {
        $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("SagaOne Site Statistics: {$this->report->environment->url}")
                    ->view('emails.statistics', ['report' => $this->report]);
    }
}
