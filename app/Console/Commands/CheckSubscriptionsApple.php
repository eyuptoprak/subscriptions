<?php

namespace App\Console\Commands;

use App\Enums\Purchase\Stores;
use App\Jobs\AppleCheckSubscriptionJob;
use App\Models\Device;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\GoogleCheckSubscriptionJob;

class CheckSubscriptionsApple extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-subscriptions-apple';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking subscription status via apple store api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      Purchase::select('receipt')
            ->whereDate('expire_date', '<', Carbon::now())
            ->where('store', Stores::Apple)
          ->limit(10)
            ->chunk(10, function($receipts) {
                foreach ($receipts as $receipt) {
                    AppleCheckSubscriptionJob::dispatch($receipt->receipt);
                }
            });




    }
}
