<?php

namespace App\Services;

use App\Operations\PurchaseHandler;

class PurchaseService
{
    public function purchase($device, $receipt)
    {
        $purchaseOperation = PurchaseHandler::handle($device->operation_system);

        return $purchaseOperation->purchase($device,$receipt);
    }
}
