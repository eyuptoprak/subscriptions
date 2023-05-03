<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppleSubscription\StoreRequest;
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
    public function store(StoreRequest $request): SubscriptionResource|ErrorResource
    {
        $receipt = $request->receipt;

        $responseData = [];
        $responseData['status'] = false;

        if ($this->isValidSubscription($receipt)) {
            $appleData['expire_date'] = $this->getExpireDate();
            $appleData['receipt'] = $request->receipt;

            if (!$subscription = AppleSubscription::create($appleData)) {
                $responseData['message'] = trans('apple.server_side_error');
                return new ErrorResource($responseData);
            }

            return new SubscriptionResource($subscription);

        } else {
            $responseData['message'] = trans('apple.is_not_valid_subscription');
            return new ErrorResource($responseData);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AppleSubscription $appleSubscription)
    {
        //
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


}
