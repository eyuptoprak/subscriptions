<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPurchaseIsCreated(): void
    {
        $device = $this->getDevice();

        $payload = [
            'receipt' => "12343",
            'client_token' => $device->client_token,
        ];



        $this->actingAs(User::factory()->create())->json('post', 'api/purchases', $payload)
            ->assertJsonStructure(
                [
                    'data' => [
                        'purchase',
                        'success',
                        'message',
                    ]

                ]
            );
    }



    private function getDevice()
    {
        return Device::factory()->create();
    }

    private function getPurchacase()
    {
        return Purchase::factory()->create();
    }
}
