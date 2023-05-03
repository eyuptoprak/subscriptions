<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleTest extends TestCase
{
    public function testDeviceIsCreatedSuccessfully()
    {
        $payload = [
            'receipt' => $this->generateOddNumber(),
            'username' => config('google.api.username'),
            'password' => config('google.api.password')
        ];


        $this->actingAs(User::factory()->create())->json('post', config('google.api.subscription_check_url'), $payload)
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'data' => [
                        'status',
                        'receipt',
                        'expire_date',
                    ]

                ]
            );
    }

    /**
     * @return int
     */
    private function generateOddNumber(): int
    {
        return $this->faker->randomNumber()  | 1;
    }
}
