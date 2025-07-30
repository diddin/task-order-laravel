<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [ // aktiftan ini jika menggunakan folder non standard
        // \App\Events\ChatRead::class => [
        //     \App\Listeners\UpdateUnreadChatCount::class,
        // ],
        // \App\Events\ChatSent::class => [
        //     \App\Listeners\UpdateUnreadChatCountOnSent::class,
        // ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
