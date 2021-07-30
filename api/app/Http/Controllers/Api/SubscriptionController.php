<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    /**
     * @param SubscriptionService $subscriptionService
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Device subscription purchase func.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchase(Request $request)
    {
        $data = $request->only(['receipt']);

        $validator = Validator::make($data, [
            'receipt' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $device = auth('device')->user();

        [$subscription, $subscriptionExpireDate] = $this->subscriptionService->purchase($data['receipt'], $device);

        if (!$subscription) {
            return response()->json([
                'status' => false,
                'errors' => ['Subscription error!']
            ], 400);
        }

        return response()->json([
            'status' => true,
            'expire_date' => $subscriptionExpireDate,
            'client' => $device
        ], 201);
    }

    /**
     * Device subscription expire check function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        $device = auth('device')->user();

        $status = $this->subscriptionService->check($device);

        if (!$status){
            return response()->json([
                'status' => false,
                'message' => 'Subscription Ended!'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Subscription continues!'
        ]);
    }
}
