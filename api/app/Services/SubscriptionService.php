<?php

namespace App\Services;

use App\Repositories\SubscriptionRepository;
use App\Services\Search\SubscriptionSearchService;
use Illuminate\Contracts\Auth\Authenticatable;

class SubscriptionService
{
    protected $subscriptionRepository;
    protected $purchaseService;
    protected $subscriptionSearchService;

    public function __construct(SubscriptionRepository $subscriptionRepository, PurchaseService $purchaseService, SubscriptionSearchService $subscriptionSearchService)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->purchaseService = $purchaseService;
        $this->subscriptionSearchService = $subscriptionSearchService;
    }

    public function purchase($receipt, Authenticatable $device)
    {
        $response = $this->purchaseService->purchase($device, $receipt);

        if (!$response['status']) {
            return [null, null];
        }

        $subData = [
            'device_id' => $response['client']['id'],
            'receipt' => $receipt,
            'status' => 1,
            'expire_date' => $response['expire_date']
        ];

        $subscription = $this->subscriptionRepository->updateOrCreate($subData);

        return [$subscription, $subData['expire_date']];
    }

    public function check($device)
    {
        $params = [
            'stringFacets' => [
                [
                    'name' => 'device_id',
                    'slugs' => [$device->id],
                ]
            ]
        ];

        $subs = $this->subscriptionSearchService->search($params);

        if (!($subs['totalCount'] > 0)) {
            return false;
        }

        return $subs['results'][0]['expire_date'] > now();
    }
}
