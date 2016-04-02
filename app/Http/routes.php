<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use App\Classes\Messaging\SMS\SmartTransport;
use App\Classes\Messaging\SMS\Message;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::get('users/{username}', function($username) {
    return $username;
});

Route::get('users/{username}/activity', 'ActivitiesController@show');

Route::get('users/{username}/favorite', function(\App\Classes\User $user) {
    $post = \App\Classes\Post::first();

    $user->recordActivity('favorited', $post);
});

//Auth::loginUsingId(1);

Route::resource('users', 'UsersController');

Route::post('test', function() {
    $URL = "https://ws.smartmessaging.com.ph/soap/?wsdl";
//    $client = new SoapClient($URL);
//    $token = "9f4fefe761c95853f9b6a2f4801a1ea6";
//
//    $method = 'SENDSMS';
//    $parameters = array(
//        array(
//            'token' => $token,
//            'msisdn' => '09189362340',
//            'message' => 'The quick brown fox jumps over the lazy dog.'
//        )
//    );
//    $return = $client->__call($method, $parameters);

});

Route::get('ip', function() {
    return $_SERVER;
});

Route::get('info', function() {
    phpinfo();
});

Route::post('soap', function() {
    $URL = "https://ws.smartmessaging.com.ph/soap/?wsdl";
    $client = new soapclient($URL);
    $token = "9f4fefe761c95853f9b6a2f4801a1ea6";

    $method = 'SENDSMS';
    $parameters = array(
        array(
            'token' => $token,
            'msisdn' => '09189362340',
            'message' => 'Here in Philam'
        )
    );
    $return = $client->__call($method, $parameters);
});

Route::post('smart', function() {
//    SoapWrapper::add(function ($service) {
//        $service
//            ->name('SENDSMS')
//            ->wsdl('https://ws.smartmessaging.com.ph/soap/?wsdl')
//            ->trace(true)                                                   // Optional: (parameter: true/false)
//            ->cache(WSDL_CACHE_BOTH);                                       // Optional: Set the WSDL cache
//    });
//
//    $data = [
//        'token'         => '9f4fefe761c95853f9b6a2f4801a1ea6',
//        'msisdn'        => '09189362340',
//        'message'       => 'Smart via SOAP'
//    ];
//
//    // Using the added service
//    SoapWrapper::service('SENDSMS', function ($service) use ($data) {
//        $service->call('SENDSMS', [$data]);
//    });

// Add a new service to the wrapper
    SoapWrapper::add(function ($service) {
        $service
            ->name('currency')
            ->wsdl('http://currencyconverter.kowabunga.net/converter.asmx?WSDL')
            ->trace(true)                                                   // Optional: (parameter: true/false)
            ->header()                                                      // Optional: (parameters: $namespace,$name,$data,$mustunderstand,$actor)
            ->customHeader($customHeader)                                   // Optional: (parameters: $customerHeader) Use this to add a custom SoapHeader or extended class
            ->cookie()                                                      // Optional: (parameters: $name,$value)
            ->location()                                                    // Optional: (parameter: $location)
            ->certificate()                                                 // Optional: (parameter: $certLocation)
            ->cache(WSDL_CACHE_NONE)                                        // Optional: Set the WSDL cache
            ->options(['login' => 'username', 'password' => 'password']);   // Optional: Set some extra options
    });

    $data = [
        'CurrencyFrom' => 'USD',
        'CurrencyTo'   => 'EUR',
        'RateDate'     => '2014-06-05',
        'Amount'       => '1000'
    ];

    // Using the added service
    SoapWrapper::service('currency', function ($service) use ($data) {
        var_dump($service->getFunctions());
        var_dump($service->call('GetConversionAmount', [$data])->GetConversionAmountResult);
    });
});