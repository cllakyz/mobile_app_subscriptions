<?php

namespace App\Operations\Base;

use App\Operations\Contacts\PurchaseOperationInterface;
use Illuminate\Support\Facades\Http;

class GooglePurchaseOperation implements PurchaseOperationInterface
{
    /**
     * Google purchase operation
     *
     * @param $device
     * @param $receipt
     * @return array|mixed
     */
    public function purchase($device, $receipt)
    {
        $response = Http::asJson()->post(rtrim(config('purchase.google_api_url'), '/') . '/purchase', [
            'client' => $device,
            'receipt' => $receipt
        ]);

        return $response->json();
    }
}
