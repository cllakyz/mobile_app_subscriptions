<?php

namespace App\Operations\Base;

use App\Operations\Contacts\PurchaseOperationInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class IosPurchaseOperation implements PurchaseOperationInterface
{
    public function purchase($device, $receipt)
    {
        $response = Http::asJson()->post(rtrim(config('purchase.ios_api_url'), '/') . '/purchase', [
            'client' => $device,
            'receipt' => $receipt
        ]);

        return $response->json();
    }
}
