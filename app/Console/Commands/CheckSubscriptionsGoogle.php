<?php

namespace App\Console\Commands;

use App\Enums\Purchase\Stores;
use App\Models\Device;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\GoogleCheckSubscriptionJob;

class CheckSubscriptionsGoogle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-subscriptions-google';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking subscription status via google play store api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      Purchase::select('receipt')
            ->whereDate('expire_date', '<', Carbon::now())
            ->where('store', Stores::Google)
          ->limit(10)
            ->chunk(10, function($receipts) {
                foreach ($receipts as $receipt) {
                    GoogleCheckSubscriptionJob::dispatch($receipt->receipt);
                }
            });




    }
}
