<?php

namespace Database\Factories;

use App\Enums\StoreEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid,
            'appId' => fake()->domainWord,
            'language_code' => fake()->languageCode,
            'operating_system' => StoreEnum::randomValue(),
        ];
    }
}
