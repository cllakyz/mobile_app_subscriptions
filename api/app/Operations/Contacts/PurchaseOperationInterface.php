<?php

namespace App\Operations\Contacts;

interface PurchaseOperationInterface
{
    /**
     * Purchase operation interface
     *
     * @param $device
     * @param $receipt
     * @return mixed
     */
    public function purchase($device, $receipt);
}
