<?php

namespace App\Http\Controllers;

use App\Http\Resources\GoogleSubscription\ErrorResource;
use App\Http\Resources\GoogleSubscription\SubscriptionResource;
use App\Models\GoogleSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GoogleSubscriptionController extends Controller
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
        $receipt = $request->receipt;

        $responseData = [];
        $responseData['status'] = false;

        if ($this->isValidSubscription($receipt)) {
            $googleData['expire_date'] = $this->getExpireDate();
            $googleData['receipt'] = $request->receipt;

            if (!$google = GoogleSubscription::create($googleData)) {
                $responseData['message'] = trans('google.server_side_error');
                return new ErrorResource($responseData);
            }

            return new SubscriptionResource($google);

        } else {
            $responseData['message'] = trans('google.is_not_valid_subscription');
            return new ErrorResource($responseData);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GoogleSubscription $googleSubscription)
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
