<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    public function testDeviceIsCreatedSuccessfully()
    {
        $device = Device::factory()->create();
        $payload = [
            'uuid' => $device->uuid,
            'appId' => $device->appId,
            'language_code' => $device->language_code,
            'operating_system' => $device->operating_system
        ];
        $user = User::factory()->make();

        $this->actingAs(User::factory()->create())->json('post', 'api/devices', $payload)
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'uuid',
                        'appId',
                        'language_code',
                        'operating_system',
                        'client_token',
                        'created_at',
                        'updated_at',
                    ]

                ]
            );
        $this->assertDatabaseHas('devices', $payload);
    }
}
