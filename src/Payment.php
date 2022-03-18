<?php

namespace HumanIncubator\AllPaymentHelper;

use Illuminate\Support\Facades\Http;

Class Payment {
    private $all_payment_url;
    private $client_api_key;

    private $GMO_errors = [
        'E01050001' => 'UNPROCESSABLE_SETTLEMENT',
        'E01050002' => 'UNPROCESSABLE_SETTLEMENT',
        'E01050004' => 'UNPROCESSABLE_SETTLEMENT',
        'E01030061' => 'REFUND_NOT_AVAILABLE',
    ];

    function __construct($all_payment_url, $client_api_key) {
        $this->client_api_key = $client_api_key;
        $this->all_payment_url = $all_payment_url;
    }

    public function cancel($invoice_id) {
        try {
            $response = Http::withToken($this->client_api_key)->post("{$this->all_payment_url}/invoices/{$invoice_id}/cancel");
            
            if ($response->failed()) {
                $err_message = $this->generate_error_message_from_response($response->body());

                return [
                    'error' => true,
                    'status' => $response->status(),
                    'message' => $err_message
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

    public function cancelByOrderID($GMO_order_id) {
        try {
            $response = Http::withToken($this->client_api_key)->post("{$this->all_payment_url}/invoices/{$GMO_order_id}/cancel-by-orderid");

            if ($response->failed()) {
                $err_message = $this->generate_error_message_from_response($response->body());

                return [
                    'error' => true,
                    'status' => $response->status(),
                    'message' => $err_message
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

    private function generate_error_message_from_response($response) {
        $error = json_decode($response);
        
        $err_message = ['code' => 0, 'message' => ''];
        
        if ((isset($error->ERROR) && ($error->ERROR == 'GMO_ERROR')) || isset($error->ErrCode)) {
            $err_message['code'] = 'GMO';
            $err_message['message'] = (isset($this->GMO_errors[$error->ErrInfo])) ? $this->GMO_errors[$error->ErrInfo] : $error->ErrInfo;
        }

        return $err_message;
    }
}