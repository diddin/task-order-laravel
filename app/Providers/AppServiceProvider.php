<?php

namespace App\Providers;

use App\Services\NotificationService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $notificationService = app(NotificationService::class);
    
            $unreadTaskCount = $notificationService->getUnreadTaskCount();
            $unreadChatCount = $notificationService->getUnreadChatCount();
    
            $view->with([
                'unreadTaskCount' => $unreadTaskCount,
                'unreadChatCount' => $unreadChatCount,
            ]);
        });
    }
}
