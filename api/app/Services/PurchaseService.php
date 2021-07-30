<?php

namespace App\Services;

use App\Operations\PurchaseHandler;

class PurchaseService
{
    /**
     * Purchase service function
     *
     * @param $device
     * @param $receipt
     * @return mixed
     */
    public function purchase($device, $receipt)
    {
        $purchaseOperation = PurchaseHandler::handle($device->operation_system);

        return $purchaseOperation->purchase($device,$receipt);
    }
}
