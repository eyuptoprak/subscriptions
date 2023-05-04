<?php

namespace App\Listeners;

use App\Events\SubscriptionStatusEvent;
use App\Models\ThirdParty;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifySubscriptionStatusToThirdParty
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SubscriptionStatusEvent $event): void
    {
        $requestData['appId'] = $event->purchase->appId;
        $requestData['deviceID'] = $event->purchase->uuid;
        $requestData['status'] = $event->purchase->status;

        $thirdParties = ThirdParty::where('appId', $event->purchase->appId)->get();

        foreach ($thirdParties as $thirdParty) {
            $res = Http::post($thirdParty->url, $requestData);
        }
    }
}
