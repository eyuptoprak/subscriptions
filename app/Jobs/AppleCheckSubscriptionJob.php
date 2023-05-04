<?php

namespace App\Jobs;

use App\Enums\Purchase\PurchaseStatus;
use App\Models\Device;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class AppleCheckSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $receipt;

    private Purchase $purchase;
    private string $googleSubscriptionURL;
    private array $requestData;

    /**
     * Create a new job instance.
     */
    public function __construct($receipt)
    {
        $this->receipt = $receipt;
        $this->purchase = Purchase::where('receipt', $this->receipt)->first();
        $this->requestData['receipt'] = $receipt;
        $this->requestData['username'] = config('apple.api.username');
        $this->requestData['password'] = config('apple.api.password');
        $this->googleSubscriptionURL = config('apple.api.uri') . 'checkReceipt';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

           $response = Http::withoutVerifying()->withOptions([
                'debug' => true,
                'verifiy_host' => false,
                "verify" => false
            ])->get($this->googleSubscriptionURL.'/'.$this->requestData['receipt']);
            if ($response->successful()) {
                $responseData = $response->json('data');
                if ($responseData['status']) {

                    $renewed = $this->checkIsRenewed($this->purchase->expire_date, $responseData['expire_date']);
                    $this->purchase->status = $renewed ? PurchaseStatus::Renewed : PurchaseStatus::Started;
                } else {
                    $this->purchase->status = PurchaseStatus::Canceled;
                }

                $this->purchase->save();
            }

    }

    public function uniqueId(): int
    {
        return $this->receipt;
    }

    /**
     * @param Carbon $defaultDate
     * @param Carbon $newDate
     * @return bool
     */
    private function checkIsRenewed(Carbon $defaultDate, Carbon $newDate): bool
    {
        return $newDate->gt($defaultDate);
    }

}
