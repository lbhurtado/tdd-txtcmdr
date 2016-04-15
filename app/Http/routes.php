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
use Carbon\Carbon;
use App\Classes\Messaging\SMS\Sender;
use App\Classes\Messaging\SMS\Facades\SMS;
use App\Jobs\RecordMissive;
use App\Classes\Mobile;

//Route::bind('mobile', function($value)
//{
//    return new Mobile($value);
//});

Route::get('sms/{mobile}', 'TextCommanderController@sms');

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

Route::get('info', function() {
    phpinfo();
});

Route::post('soap', function() {
    $URL = "https://ws.smartmessaging.com.ph/soap/?wsdl";
    $client = new \SoapClient($URL);
    $token = "9f4fefe761c95853f9b6a2f4801a1ea6";

    $method = 'SENDSMS';
    $parameters = array(
        array(
            'token' => $token,
            'msisdn' => '09173011987',
            'message' => 'smart via soap client'
        )
    );

    $client->__call($method, $parameters);

    return "ok";
});

Route::get('env', function () {
//    $this->app['config']['sender.driver']
   $environment = Config::get('sms.driver');

    return $environment;
});

Route::post('send/{mobile}/{body}', function($mobile, $body) {
    $message =
        ( new Message
        (
            'sms.testing.transport',
            [
                'header' => "Text Commander:",
                'body' => $body ,
                'footer' => Carbon::now('Asia/Manila')
            ]
        ))
            ->to($mobile);

//    $sender = $this->app->make(Sender::class);

//    $sender->send($message);

    SMS::send($message);
});

Route::post('smart', function() {
//    $body = "BBM must win! I can help. https://www.flickr.com/photos/140231993@N04/shares/16Cd76";

    $body = "Duterte's votes must be counted! We can help. \nhttp://www.slideshare.net/secret/A2owAsP3naQlXn\n";

    $message = (new Message('sms.testing.transport',
        [
            'header' => "Hi Tito Bebot.\n",
            'body' => $body,
            'footer' => "Lester (09189362340)\ncc:Patmei"
        ]
           ))->to('09173232360')->to('09998894478')->to('09189362340');
    //    ))->to('09189085492')->to('09175294599')->to('09189362340');


//    return $message->composeMessage();

//    ))->to('639178907531')->to('639285078279')->to('09175339430')->to('09178009081')->to('09173011987');

    $transport = new SmartTransport();

    $transport->send($message);

    return "Sent to Tito Bebot!";
});

Route::group(['prefix'=>'telerivet'], function ($app) {
    Route::post('webhook', 'TelerivetController@webhook');
});