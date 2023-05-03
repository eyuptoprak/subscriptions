<?php

namespace App\Http\Controllers;

use App\Http\Requests\Device\StoreRequest;
use App\Http\Resources\Device\StoreResource;
use App\Models\Device;

class DeviceController extends Controller
{


    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $device = Device::updateOrCreate(['uuid' => $request->uuid, 'appId'=> $request->appId], request()->all());

        return (new StoreResource($device))
            ->response()
            ->setStatusCode(201);
    }


}
