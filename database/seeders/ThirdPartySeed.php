<?php

namespace Database\Seeders;

use App\Models\ThirdParty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThirdPartySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $thirdParties = [
            [
                'url' => 'consomer1.subscriptions.test/google',
                'appId' => 'test',
            ],
            [
                'url' => 'consomer2.subscriptions.test/google',
                'appId' => 'test',
            ],
            [
                'url' => 'consomer3.subscriptions.test/apple',
                'appId' => 'test2',
            ],
        ];

        foreach ($thirdParties as $party) {
            ThirdParty::firstOrCreate(['url' => $party['url'], 'appId'=>$party['appId']], $party);
        }
    }
}
