<?php

namespace App\Providers;

use App\Services\Notifications\EmailNotificationService;
use App\Services\Notifications\INotificationService;
use App\Services\Notifications\NotificationServiceInterface;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(INotificationService::class, EmailNotificationService::class);
    }
}