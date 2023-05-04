<?php

namespace App\Http\Controllers;

use App\Enums\Purchase\PurchaseStatus;
use App\Enums\Purchase\Stores;
use App\Http\Requests\Purchase\StoreRequest;
use App\Http\Resources\Purchase\ErrorResource;
use App\Http\Resources\Purchase\PurchaseResource;
use App\Models\Device;
use App\Models\Purchase;
use Illuminate\Support\Facades\Http;

/**
 *
 */
class PurchaseController extends Controller
{
    /**
     * @var array
     */
    private array $responseData = [];

    private string $googleSubscriptionURL;
    private string $appleSubscriptionURL;


    public function __construct()
    {
        $this->googleSubscriptionURL = config('google.api.uri') . 'subscriptions';
        $this->appleSubscriptionURL = config('apple.api.uri') . 'subscriptions';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * @param StoreRequest $request
     * @return PurchaseResource|ErrorResource
     */
    public function store(StoreRequest $request): PurchaseResource|ErrorResource
    {
        $clientToken = $request->client_token;

        $device = Device::where('client_token', $clientToken)->first();

        $res = $this->checkSubscriptionStatus($device->operating_system, $request->receipt);

        if (!$res) {
            $this->responseData['message'] = trans('purchase.purchase_os_error');
            return $this->occurredError();
        }

        if ($res->successful()) {
            $responseData = $res->json('data');
        } else {
            $this->responseData['message'] = trans('purchase.purchase_api_error');
            return $this->occurredError();
        }


        $purchase = new Purchase();
        $purchase->receipt = $request->receipt;
        $purchase->client_token = $request->client_token;
        $purchase->status = PurchaseStatus::Started;
        $purchase->appId = $device->appId;
        $purchase->store = $device->operating_system;
        $purchase->expire_date = $responseData['expire_date'];


        if ($purchase->save()) {
            $this->responseData['message'] = trans('purchase.successful');
            $this->responseData['purchase'] = $purchase;
        } else {
            $this->responseData['message'] = trans('purchase.purchase_create_error');
            return $this->occurredError();
        }


        return new PurchaseResource($this->responseData);
    }


    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }


    /**
     * @param $receipt
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    private function checkGoogle($receipt): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $requestData['receipt'] = $receipt;
        $requestData['username'] = config('google.api.username');
        $requestData['password'] = config('google.api.password');

        return $this->requestApi($this->googleSubscriptionURL, $requestData);
    }

    /**
     * @param $receipt
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    private function checkApple($receipt): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $requestData['receipt'] = $receipt;
        $requestData['username'] = config('apple.api.username');
        $requestData['password'] = config('apple.api.password');
        return $this->requestApi($this->appleSubscriptionURL, $requestData);
    }

    /**
     * @param $store
     * @param $receipt
     * @return false|\GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    private function checkSubscriptionStatus($store, $receipt)
    {
        return match ($store) {
            Stores::Google->value => $this->checkGoogle($receipt),
            Stores::Apple->value => $this->checkApple($receipt),
            default => false,
        };
    }

    /**
     * @param string $api
     * @param array $requestData
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    private function requestApi(
        string $api,
        array $requestData
    ): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response {
        return Http::asForm()->withoutVerifying()->withOptions([
            'debug' => true,
            'verifiy_host' => false,
            "verify" => false
        ])->post($api, $requestData);
    }

    /**
     * @return ErrorResource
     */
    public function occurredError(): ErrorResource
    {
        return new ErrorResource($this->responseData);
    }


}
