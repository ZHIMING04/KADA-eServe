<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define roles
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Pengesahan Alamat E-mel')
                ->line('Klik butang di bawah untuk mengesahkan alamat e-mel anda.')
                ->action('Sahkan Alamat E-mel', $url);
        });
    }
}
