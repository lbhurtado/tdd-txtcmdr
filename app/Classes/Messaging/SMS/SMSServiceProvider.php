<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 19/04/16
 * Time: 07:59
 */

namespace App\Classes\Messaging\SMS;

use SimpleSoftwareIO\SMS\SMSServiceProvider as SimpleSMSServiceProvider;
use App\Classes\Messaging\SMS\Extensions\DriverManager;

class SMSServiceProvider extends SimpleSMSServiceProvider
{
    public function registerSender()
    {
        parent::registerSender();

        $this->app['sms.sender'] = $this->app->share(function ($app) {
            return (new DriverManager($app))->driver();
        });
    }
}
