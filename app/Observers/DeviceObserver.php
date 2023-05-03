<?php

namespace App\Observers;

use App\Models\Device;
use Illuminate\Support\Str;

class DeviceObserver
{

    /**
     * @param Device $device
     * @return void
     */
    public function created(Device $device): void
    {
        $device->client_token = Str::random(60);
        $device->save();
    }
}
