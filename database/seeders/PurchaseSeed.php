<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PurchaseSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noOfRows = 1000000;
        $range = range(1, $noOfRows);
        $chunkSize = 1000;

        foreach (array_chunk($range, $chunkSize) as $chunk) {
            $purchaseData = array();
            foreach ($chunk as $i) {
                $purchaseData[] = [
                    'receipt' => fake()->randomNumber(),
                    'appId' => 'app1',
                    'client_token' => Str::random(60),
                    'status' => 'started',
                    'store' => 'google',
                    'expire_date' => fake()->dateTime(),
                ];
            }
            Purchase::insert($purchaseData);
        }
    }
}
