<?php
namespace HumanIncubator\AllPaymentHelper;

use Illuminate\Support\ServiceProvider;

class AllpaymentServiceProvider extends ServiceProvider {
    public function boot() {

    }

    public function register() {
        $this->publishes([
            __DIR__.'/../config/allpayment.php' => config_path('allpayment.php'),
        ]);
    }
}