<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
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
        if (env('APP_ENV') == 'production') {
            URL::forceScheme('https');
        }

        VerifyEmail::toMailusing(function ($notifiable) {

            Mail::to($notifiable)->send(new VerifyEmailMailable($notifiable));

/*
$verificationUrl = URL::temporarySignedRoute(
    'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
);

return (new MailMessage)
        ->subject('Please verify your email address')
        ->greeting("Nice to meet you, {$notifiable->name}!")
        ->line('Thank you for registering for SagaOne! Please click the button below to verify your email address.')
        ->action('Verify Email Address', $verificationUrl)
        ->line('If you did not create an account, you may disregard this email.');
*/


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
