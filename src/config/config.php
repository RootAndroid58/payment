<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Service Config for RootAndroid58/Payments
    |--------------------------------------------------------------------------
    |   gateway = CCAvenue / PayUMoney / EBS / Citrus / InstaMojo / ZapakPay / Paytm / Mocker
    */

    'gateway' => env('PAYMENT_DEFAULTGATEWAY', 'Mocker'),                // Replace with the name of default gateway you want to use

    'testMode'  => env('PAYMENT_TESTMODEENV', true),                   // True for Testing the Gateway [For production false]
    
    // CCAvenue Parameters
    'ccavenue' => [                         
        'merchantId'  => env('PAYMENT_CCAVENUE_MERCHANT_ID', ''),
        'accessCode'  => env('PAYMENT_CCAVENUE_ACCESS_CODE', ''),
        'workingKey' => env('PAYMENT_CCAVENUE_WORKING_KEY', ''),

        // Should be route address for url() function
        'redirectUrl' => env('PAYMENT_CCAVENUE_REDIRECT_URL', 'payment/response'),
        'cancelUrl' => env('PAYMENT_CCAVENUE_CANCEL_URL', 'payment/response'),

        'currency' => env('PAYMENT_CCAVENUE_CURRENCY', 'INR'),
        'language' => env('PAYMENT_CCAVENUE_LANGUAGE', 'EN'),
    ],
     // PayUMoney Parameters
    'payumoney' => [                        
        'merchantKey'  => env('PAYMENT_PAYU_MERCHANT_KEY', ''),
        'salt'  => env('PAYMENT_PAYU_SALT', ''),
        'workingKey' => env('PAYMENT_PAYU_WORKING_KEY', ''),

        // Should be route address for url() function
        'successUrl' => env('PAYMENT_PAYU_SUCCESS_URL', 'payment/response'),
        'failureUrl' => env('PAYMENT_PAYU_FAILURE_URL', 'payment/response'),
    ],
    // EBS Parameters
    'ebs' => [                         
        'account_id'  => env('PAYMENT_EBS_MERCHANT_ID', ''),
        'secretKey' => env('PAYMENT_EBS_WORKING_KEY', ''),

        // Should be route address for url() function
        'return_url' => env('PAYMENT_EBS_SUCCESS_URL', 'payment/response'),
    ],
     // Citrus Parameters
    'citrus' => [                        
        'vanityUrl'  => env('PAYMENT_CITRUS_VANITY_URL', ''),
        'secretKey' => env('PAYMENT_CITRUS_WORKING_KEY', ''),

        // Should be route address for url() function
        'returnUrl' => env('PAYMENT_CITRUS_SUCCESS_URL', 'payment/response'),
        'notifyUrl' => env('PAYMENT_CITRUS_NOTIFY_URL', 'payment/response'),
    ],

    'instamojo' =>  [
        'api_key' => env('INSTAMOJO_API_KEY',''),
        'auth_token' => env('INSTAMOJO_AUTH_TOKEN',''),
        'redirectUrl' => env('PAYMENT_INSTAMOJO_REDIRECT_URL', 'payment/response'),
    ],

    'mocker' => [
        'service' => env('MOCKER_SERVICE','default'),
        'redirect_url' => env('MOCKER_REDIRECT_URL', 'payment/response'),
    ],

    'zapakpay' =>  [
        'merchantIdentifier' => env('ZAPAKPAY_MERCHANT_ID',''),
        'secret' => env('ZAPAKPAY_SECRET', ''),
        'returnUrl' => env('ZAPAKPAY_RETURN_URL', 'payment/response'),
    ],

    'paytm' =>  [
        'MERCHANT_KEY' => env('PAYTM_MERCHANT_KEY',''),
        'MID' => env('PAYTM_MID', ''),
        'CHANNEL_ID' => env('PAYTM_CHANNEL_ID', 'WEB'),
        'WEBSITE' => env('PAYTM_WEBSITE', 'WEBSTAGING'),
        'INDUSTRY_TYPE_ID' => env('PAYTM_INDUSTRY_TYPE_ID', 'Retail'),
        'REDIRECT_URL' => env('PAYTM_REDIRECT_URL', 'payment/response'),
    ],

    'cashfree' => [
        'appID' => env('PAYMENT_CASHFREE_APPID',''),
        'secretKey' => env('PAYMENT_CASHFREE_SECRETKEY',''),
        'Currency' => env('PAYMENT_CASHFREE_CURRENCY',''),
        'notifyUrl' => env('PAYMENT_CASHFREE_NOTIFYURL','payment/response'),
        'returnUrl' => env('PAYMENT_CASHFREE_RETURNURL','payment/response'),
    ],

    // Add your response link here. In Laravel 5.2+ you may use the VerifyCsrf Middleware.
    'remove_csrf_check' => [
        'payment/*'
    ],





];