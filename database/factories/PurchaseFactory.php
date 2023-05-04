<?php

namespace Database\Factories;

use App\Enums\Purchase\PurchaseStatus;
use App\Enums\Purchase\Stores;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receipt' => fake()->randomNumber(),
            'appId' => 'app1',
            'client_token' => Str::random(60),
            'status' => 'renewed',
            'store' => 'google',
            'expire_date' => fake()->dateTime(),
        ];
    }
}
