<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function updateOrCreate(array $data)
    {
        return $this->subscription->updateOrCreate(
            [
                'device_id' => $data['device_id'],
            ],
            [
                'receipt' => $data['receipt'],
                'status' => $data['status'],
                'expire_date' => $data['expire_date']
            ]
        );
    }
}
