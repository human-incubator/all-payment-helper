<?php

namespace HumanIncubator\AllPaymentHelper;

use Illuminate\Support\Facades\Http;

Class Payment {
    private $all_payment_url;
    private $client_api_key;

    function __construct($all_payment_url, $client_api_key) {
        $this->client_api_key = $client_api_key;
        $this->all_payment_url = $all_payment_url;
    }

    public function cancel($invoice_id) {
        $response = Http::withToken($this->client_api_key)->post("{$this->all_payment_url}/invoices/{$invoice_id}/cancel");
        
        if ($response->failed()) {
            return [
                'error' => true,
                'status' => $response->status(),
                'message' => $response->body()
            ];
        } else {
            return json_decode($response);
        }
    }

    public function cancelByOrderID($GMO_order_id) {
        $response = Http::withToken($this->client_api_key)->post("{$this->all_payment_url}/invoices/{$GMO_order_id}/cancel-by-orderid");
        
        if ($response->failed()) {
            return [
                'error' => true,
                'status' => $response->status(),
                'message' => $response->body()
            ];
        } else {
            return json_decode($response);
        }
    }
}