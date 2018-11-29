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
        }

        VerifyEmail::toMailusing(function ($notifiable) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
            );

            return (new MailMessage)
                ->subject('Please verify your email address')
                ->greeting("Nice to meet you, {$notifiable->name}!")
                ->line('Thank you for registering for SagaOne! Please click the button below to verify your email address.')
                ->action('Verify Email Address', $verificationUrl)
                ->line('If you did not create an account, you may disregard this email.');
        });

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
