<?php


namespace App\Services\Payment\Paypal;


interface PaymentPaypalInterface
{
    public function Payment(array $product):void;
}