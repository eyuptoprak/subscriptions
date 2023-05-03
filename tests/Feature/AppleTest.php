<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppleTest extends TestCase
{
    public function testAppleReceiptIsCreatedSuccessfully()
    {
        $payload = [
            'receipt' => $this->generateOddNumber(),
            'username' => config('apple.api.username'),
            'password' => config('apple.api.password')
        ];


        $this->actingAs(User::factory()->create())->json('post', config('apple.api.subscription_check_url'), $payload)
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
