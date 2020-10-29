<?php namespace RootAndroid58\Payment\Gateways;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use RootAndroid58\Payment\Exceptions\PaymentParametersMissingException;

class EBSGateway implements PaymentGatewayInterface {

    protected $parameters = array();
    protected $testMode = false;
    protected $merchantKey = '';
    protected $salt = '';
    protected $hash = '';
    protected $endPoint = 'https://secure.ebs.in/pg/ma/payment/request';
    public $response = '';

    function __construct()
    {
        $this->secretKey = Config::get('payment.ebs.secretKey');
        $this->testMode = Config::get('payment.testMode');

        $this->parameters['channel'] = 0;       // Standard
        $this->parameters['account_id'] = Config::get('payment.ebs.account_id');
        $this->parameters['reference_no'] = $this->generateTransactionID();
        $this->parameters['currency'] = 'INR';
        $this->parameters['mode'] = 'LIVE';
        if($this->testMode){
            $this->parameters['mode'] = 'TEST';
        }
        $this->parameters['return_url'] = url(Config::get('payment.ebs.return_url'));


    }

    public function getEndPoint()
    {
        return $this->endPoint;
    }

    public function request($parameters)
    {
        $this->parameters = array_merge($this->parameters,$parameters);

        $this->checkParameters($this->parameters);

        $this->encrypt();

        return $this;

    }

    /**
     * @return mixed
     */
    public function send()
    {

        Log::info('payment Payment Request Initiated: ');
        return View::make('payment::ebs')->with('hash',$this->hash)
                             ->with('parameters',$this->parameters)
                             ->with('endPoint',$this->getEndPoint());

    }


    /**
     * Check Response
     * @param $request
     * @return array
     */
    public function response($request)
    {
        $response = $request->all();

        return $response;
    }


    /**
     * @param $parameters
     * @throws PaymentParametersMissingException
     */
    public function checkParameters($parameters)
    {
        $validator = Validator::make($parameters, [
            'channel' => 'required',
            'account_id' => 'required',
            'reference_no' => 'required',
            'mode' => 'required',
            'currency' => 'required',
            'description' => 'required',
            'return_url' => 'required|url',
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new PaymentParametersMissingException;
        }

    }

    /**
     * EBS Encrypt Function
     *
     */
    protected function encrypt()
    {
        $this->hash = '';
        $hash_string = $this->secretKey."|".urlencode($this->parameters['account_id'])."|".urlencode($this->parameters['amount'])."|".urlencode($this->parameters['reference_no'])."|".$this->parameters['return_url']."|".urlencode($this->parameters['mode']);
        $this->hash = md5($hash_string);
    }

    /**
     * EBS Decrypt Function
     *
     * @param $plainText
     * @param $key
     * @return string
     */
    protected function decrypt($response)
    {

        return $response;
    }



    public function generateTransactionID()
    {
        return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    }




}