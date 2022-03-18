<?php

namespace HumanIncubator\AllPaymentHelper;

use Illuminate\Support\Facades\Http;

Class Invoice {
    public $amount;
    public $customer_name;
    public $particulars;
    public $callback_url;
    public $client_invoice_id;
    
    private $all_payment_url;
    private $client_api_key;

    function __construct($all_payment_url, $client_api_key) {
        $this->client_api_key = $client_api_key;
        $this->all_payment_url = $all_payment_url;
    }

    public function create() {
        try {
            $response = Http::withToken($this->client_api_key)->post("{$this->all_payment_url}/invoices", [
                'amount'            => (float) $this->amount,
                'customer_name'     => $this->customer_name,
                'particulars'       => $this->particulars,
                'client_invoice_id' => $this->client_invoice_id,
                'callback_url'      => $this->callback_url,
            ]);
            
            if ($response->failed()) {
                return [
                    'error' => true,
                    'status' => $response->status(),
                    'message' => json_decode($response->body())
                ];
            } else {
                return json_decode($response);
            }
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'status' => 500,
                'message' => ['code' => $th->getCode(), 'message'=> $th->getMessage()]
            ];
        }
    }
}