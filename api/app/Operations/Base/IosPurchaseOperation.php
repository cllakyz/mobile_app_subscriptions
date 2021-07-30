<?php

namespace App\Operations\Base;

use App\Operations\Contacts\PurchaseOperationInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class IosPurchaseOperation implements PurchaseOperationInterface
{
    /**
     * Ios purchase operation
     *
     * @param $device
     * @param $receipt
     * @return array|mixed
     */
    public function purchase($device, $receipt)
    {
        $response = Http::asJson()->post(rtrim(config('purchase.ios_api_url'), '/') . '/purchase', [
            'client' => $device,
            'receipt' => $receipt
        ]);

        return $response->json();
    }
}
