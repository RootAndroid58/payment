<?php namespace RootAndroid58\Payment;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $gateway = Config::get('payment.gateway');
        $this->app->bind('payment', 'RootAndroid58\Payment\payment');

        $this->app->bind('RootAndroid58\Payment\Gateways\PaymentGatewayInterface','RootAndroid58\Payment\Gateways\\'.$gateway.'Gateway');
	}


    public function boot(){
        $this->publishes([
            __DIR__.'/config/config.php' => base_path('config/payment.php'),
            __DIR__.'/views/middleware.blade.php' => base_path('app/Http/Middleware/VerifyCsrfMiddleware.php'),
        ]);

		$this->loadViewsFrom(__DIR__.'/views', 'payment');

    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [

        ];
	}

}