<?php namespace RootAndroid58\Payment\Gateways;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use RootAndroid58\Payment\Exceptions\PaymentParametersMissingException;

class CashfreeGateway implements PaymentGatewayInterface {

    protected $parameters = array();
    protected $testMode = false;
    protected $appid = '';
    protected $secretKey = '';
    protected $signature = '';
    protected $liveEndPoint = 'https://www.cashfree.com/checkout/post/submit';
    protected $testEndPoint = 'https://test.cashfree.com/billpay/checkout/post/submit';
    public $response = '';

    function __construct()
    {
        $this->appid = Config::get('payment.cashfree.appID');
        $this->secretKey = Config::get('payment.cashfree.secretKey');
        $this->testMode = Config::get('payment.testMode');

        $this->parameters['appId'] = $this->appid;
        $this->parameters['returnUrl'] = url(Config::get('payment.cashfree.returnUrl'));
        $this->parameters['notifyUrl'] = url(Config::get('payment.cashfree.notifyUrl'));
        $this->parameters['orderCurrency'] = url(Config::get('payment.cashfree.Currency'));
    }

    public function getEndPoint()
    {
        return $this->testMode?$this->testEndPoint:$this->liveEndPoint;
    }

    public function request($parameters)
    {
        $this->parameters = array_merge($this->parameters,$parameters);
        
        $this->encrypt();
        
        $this->parameters['signature'] = $this->$signature;

        $this->checkParameters($this->parameters);

        dd($this->parameters);
        return $this;

    }

    /**
     * @return mixed
     */
    public function send()
    {

        Log::info('payment Payment Request Initiated: ');
        return View::make('payment::cashfree')->with('signature',$this->hash)
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
        dd($response);
        $response_hash = $this->decrypt($response);

        if($response_hash!=$response['hash']){
            return 'Hash Mismatch Error';
        }

        return $response;
    }


    /**
     * @param $parameters
     * @throws PaymentParametersMissingException
     */
    public function checkParameters($parameters)
    {
        $validator = Validator::make($parameters, [
            'appId' => 'required',
            'orderId' => 'required',
            'orderAmount' => 'required|numeric',
            'orderCurrency' => 'required',
            'orderNote' => 'required',
            'customerName' => 'required',
            'customerPhone' => 'required',
            'customerEmail' => 'required',
            'returnUrl' => 'required|url',
            'notifyUrl' => 'required|url',
            'signature' => 'required',
        ]);

        if ($validator->fails()) {
            dd($validator);
            throw new PaymentParametersMissingException;
        }

    }

    /**
     * PayUMoney Encrypt Function
     *
     */
    protected function encrypt()
    {
        $this->hash = '';
        ksort($this->parameters);
        $signatureData = "";
        foreach ($postData as $key => $value){
            $signatureData .= $key.$value;
        }
        $this->$signature = hash_hmac('sha256', $signatureData, CASHFREE_SECRET_KEY,true);
        $this->$signature = base64_encode($signature);
    }

    /**
     * PayUMoney Decrypt Function
     *
     * @param $plainText
     * @param $key
     * @return string
     */
    protected function decrypt($response)
    {

        $hashSequence = "status||||||udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = $this->salt."|";

        foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($response[$hash_var]) ? $response[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string = trim($hash_string,'|');

        return strtolower(hash('sha512', $hash_string));
    }

}