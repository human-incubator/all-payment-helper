<?php

namespace HumanIncubator\AllPaymentHelper;

use HumanIncubator\AllPaymentHelper\Invoice;
use HumanIncubator\AllPaymentHelper\Payment;
use Illuminate\Support\Facades\Config;

Class AllPayment {
    static $all_payment_url;
    static $client_api_key;

    private static function init() {
        self::$all_payment_url = Config::get('allpayment.api_url');
        self::$client_api_key = Config::get('allpayment.token');
    }

    public static function create_invoice($amount, $callback_url = '', $order_id = '') {
        self::init();

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
        self::init();
        $payment = new Payment(self::$all_payment_url, self::$client_api_key);

        if ($by_invoice) {
            return $payment->cancel($id);
        } else {
            return $payment->cancelByOrderID($id);
        }
    }
}