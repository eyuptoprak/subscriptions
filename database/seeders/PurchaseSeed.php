<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Seeder;

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
                $purchaseData[] = Purchase::factory()->create();
            }
            Purchase::insert($purchaseData);
        }
    }
}
