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
    SoapWrapper::add(function ($service) {
        $service
            ->name('SENDSMS')
            ->wsdl('https://ws.smartmessaging.com.ph/soap/?wsdl')
            ->trace(true)                                                   // Optional: (parameter: true/false)
            ->cache(WSDL_CACHE_BOTH);                                       // Optional: Set the WSDL cache
    });

    $data = [
        'token'         => '9f4fefe761c95853f9b6a2f4801a1ea6',
        'msisdn'        => '09189362340',
        'message'       => 'Third message'
    ];

    // Using the added service
    SoapWrapper::service('SENDSMS', function ($service) use ($data) {
        $service->call('SENDSMS', [$data]);
    });
});

Route::get('ip', function() {
    $externalContent = file_get_contents('http://checkip.dyndns.com/');
    preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
    $externalIp = $m[1];

    return $externalIp;
});

Route::get('info', function() {
    phpinfo();
});

Route::post('soap', function() {
    $client = new SoapClient($URL);
    $token = "9f4fefe761c95853f9b6a2f4801a1ea6";

    $method = 'SENDSMS';
    $parameters = array(
        array(
            'token' => $token,
            'msisdn' => '09189362340',
            'message' => 'The quick brown fox jumps over the lazy dog.'
        )
    );
    $return = $client->__call($method, $parameters);
});