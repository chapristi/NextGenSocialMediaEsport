<?php


namespace App\Services\Payment\Paypal;


use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

class PaymentPaypal implements PaymentPaypalInterface
{

    public function Payment(array $product): void
    {
        $environment = new SandboxEnvironment(getenv("CLIENT_ID"), getenv("CLIENT_PASSWORD"));
        $client = new PayPalHttpClient($environment);
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
           $product
        ];

        try {
            $response = $client->execute($request);
            print_r($response);
        }catch (HttpException $ex) {

        }
    }
}