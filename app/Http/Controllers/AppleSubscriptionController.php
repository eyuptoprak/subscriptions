<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppleSubscription\ErrorResource;
use App\Http\Resources\AppleSubscription\SubscriptionResource;
use App\Models\AppleSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppleSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * @param Request $request
     * @return SubscriptionResource|ErrorResource
     */
    public function store(Request $request): SubscriptionResource|ErrorResource
    {
        $this->request = $request;

        return $this->getReceiptStatus();
    }

    /**
     * Display the specified resource.
     */
    public function checkReceipt(Request $request): SubscriptionResource|ErrorResource
    {
        $this->request = $request;
        return $this->getReceiptStatus();
    }

    /**
     * @return Carbon
     */
    private function getExpireDate(): Carbon
    {
        $subscriptionDays = [14, 30, 180, 360];
        shuffle($subscriptionDays);

        return Carbon::now()->addDays($subscriptionDays[0]);
    }

    /**
     * @param int $receiptNumber
     * @return bool
     */
    private function isValidSubscription(int $receiptNumber): bool
    {
        $receiptLastNumber = substr($receiptNumber, -1);
        return $receiptLastNumber % 2 != 0 && $receiptLastNumber > 0;
    }


    /**
     * @return ErrorResource|SubscriptionResource
     */
    private function getReceiptStatus()
    {
        $receipt = $this->request->receipt;

        $responseData = [];
        $responseData['status'] = false;

        if ($this->isValidSubscription($receipt)) {
            $appleData['expire_date'] = $this->getExpireDate();
            $appleData['receipt'] = $receipt;

            if (!$apple = AppleSubscription::create($appleData)) {
                $responseData['message'] = trans('apple.server_side_error');
                return new ErrorResource($responseData);
            }

            return new SubscriptionResource($apple);
        } else {
            $responseData['message'] = trans('apple.is_not_valid_subscription');
            return new ErrorResource($responseData);
        }
    }


}
