<?php namespace RootAndroid58\Payment;

use RootAndroid58\Payment\Gateways\CCAvenueGateway;
use RootAndroid58\Payment\Gateways\CitrusGateway;
use RootAndroid58\Payment\Gateways\EBSGateway;
use RootAndroid58\Payment\Gateways\InstaMojoGateway;
use RootAndroid58\Payment\Gateways\PaytmGateway;
use RootAndroid58\Payment\Gateways\PaymentGatewayInterface;
use RootAndroid58\Payment\Gateways\PayUMoneyGateway;
use RootAndroid58\Payment\Gateways\MockerGateway;
use RootAndroid58\Payment\Gateways\ZapakPayGateway;

class Payment {

    protected $gateway;

    /**
     * @param PaymentGatewayInterface $gateway
     */
    function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function purchase($parameters = array())
    {

        return $this->gateway->request($parameters)->send();

    }

    public function response($request)
    {
        return $this->gateway->response($request);
    }

    public function prepare($parameters = array())
    {
        return $this->gateway->request($parameters);
    }

    public function verify($parameters = array())
    {
        return $this->gateway->verify($parameters);
    }

    public function process($order)
    {
        return $order->send();
    }

    public function gateway($name)
    {
        $name = strtolower($name);
        switch($name)
        {
            case 'cashfree':
                $this->gateway = new CashfreeGateway();
                break;

            case 'ccavenue':
                $this->gateway = new CCAvenueGateway();
                break;
                
            case 'citrus':
                $this->gateway = new CitrusGateway();
                break;

            case 'ebs':
                $this->gateway = new EBSGateway();
                break;

            case 'instamojo':
                $this->gateway = new InstaMojoGateway();
                break;

            case 'instamojo':
                $this->gateway = new InstaMojoGateway();
                break;
            
            case 'mocker':
                $this->gateway = new MockerGateway();
                break;

            case 'paytm':
                $this->gateway = new PaytmGateway();
                break;

            case 'payumoney':
                $this->gateway = new PayUMoneyGateway();
                break;

            case 'zapakpay':
                $this->gateway = new ZapakPayGateway();
                break;

        }

        return $this;
    }



}