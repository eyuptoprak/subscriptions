<?php

namespace App\Http\Resources\Device;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => '',
            'uuid' => $this->uuid,
            'appId' => $this->appId,
            'language_code' => $this->language_code,
            'operating_system' => $this->operating_system,
            'client_token' => $this->client_token,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
