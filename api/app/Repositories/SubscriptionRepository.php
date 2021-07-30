<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    protected $subscription;

    /**
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Subcscription update or create function
     *
     * @param array $data
     * @return mixed
     */
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
