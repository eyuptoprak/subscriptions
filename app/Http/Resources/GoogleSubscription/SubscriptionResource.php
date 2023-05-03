<?php

namespace App\Http\Resources\GoogleSubscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => true,
            'receipt' => $this->receipt,
            'expire_date' => $this->expire_date->setTimeZone('America/New_York')->format('Y-m-d H:i:s'),
        ];
    }
}
