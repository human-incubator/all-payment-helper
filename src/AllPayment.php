<?php

namespace HumanIncubator\AllPaymentHelper;

use HumanIncubator\AllPaymentHelper\Invoice;
use HumanIncubator\AllPaymentHelper\Payment;

Class AllPayment {
    static $all_payment_url = 'http://127.0.0.1:8000';
    static $client_api_key = 'testkey123';

    public static function create_invoice($amount, $callback_url = '', $order_id = '') {

        $invoice = new Invoice(self::$all_payment_url, self::$client_api_key);
        $invoice->amount = (float) $amount;
        $invoice->client_invoice_id = $order_id;
        $invoice->callback_url = $callback_url;

        return $invoice->create();
    }

    public function pay() {
        // No function yet
    }

    public static function cancel($id, $by_invoice = true) {
        $payment = new Payment(self::$all_payment_url, self::$client_api_key);

        if ($by_invoice) {
            return $payment->cancel($id);
        } else {
            return $payment->cancelByOrderID($id);
        }
    }
}