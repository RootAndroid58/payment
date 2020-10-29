<?php namespace RootAndroid58\Payment\Gateways;

interface PaymentGatewayInterface {
    public function request($parameters);
    public function send();
    public function response($request);
}