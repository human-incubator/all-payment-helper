<?php

namespace HumanIncubator\AllPaymentHelper;

use HumanIncubator\AllPaymentHelper\Invoice;
use HumanIncubator\AllPaymentHelper\Payment;

Class AllPayment {
    public $all_payment_url = 'http://127.0.0.1:8000';
    private $client_api_key = 'testkey123';

    public static function create_invoice($amount, $callback_url = '', $order_id = '') {

        $invoice = new Invoice($this->all_payment_url, $this->client_api_key);
        $invoice->amount = (float) $amount;
        $invoice->client_invoice_id = $order_id;
        $invoice->callback_url = $callback_url;

        return $invoice->create();
    }

    public function pay() {
        // No function yet
    }

    public static function cancel($id, $by_invoice = true) {
        $payment = new Payment($this->all_payment_url, $this->client_api_key);

        if ($by_invoice) {
            return $payment->cancel($id);
        } else {
            return $payment->cancelByOrderID($id);
        }
    }
}