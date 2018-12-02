<?php

namespace App\Providers;

use App\Mail\VerifyEmailMailable;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (App::environment('worker')) {
            // Force the URL generator to use the url specified in the env settings.
            // Otherwise the worker uses host 'localhost' for some reason.
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }

        // Queue logging
        Queue::after(function (JobProcessed $event) {
            Log::debug('Queue worker has completed a job:', [
                'connection' => $event->connectionName,
                'job' => $event->job,
                'payload' => $event->job->payload()
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
