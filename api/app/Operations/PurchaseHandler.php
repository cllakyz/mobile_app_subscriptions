<?php

namespace App\Operations;

use App\Operations\Base\GooglePurchaseOperation;
use App\Operations\Base\IosPurchaseOperation;
use App\Operations\Contacts\PurchaseOperationInterface;

class PurchaseHandler
{
    private const STRING_PARAM = 'android';

    /**
     * Device os handler
     *
     * @param string $operatingSystem
     * @return PurchaseOperationInterface
     */
    public static function handle(string $operatingSystem) : PurchaseOperationInterface
    {
        return !stripos($operatingSystem, self::STRING_PARAM) ? new GooglePurchaseOperation() : new IosPurchaseOperation();
    }
}
