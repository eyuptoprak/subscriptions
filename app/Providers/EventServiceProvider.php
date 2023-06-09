<?php

namespace App\Providers;

use App\Listeners\NotifySubscriptionStatusToThirdParty;
use App\Models\Device;
use App\Observers\DeviceObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\SubscriptionStatusEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SubscriptionStatusEvent::class => [
            NotifySubscriptionStatusToThirdParty::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Device::observe(DeviceObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
