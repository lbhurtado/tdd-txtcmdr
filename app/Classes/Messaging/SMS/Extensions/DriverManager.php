<?php

namespace App\Classes\Messaging\SMS\Extensions;

use App\Classes\Messaging\SMS\Extensions\Drivers\Telerivet;
use App\Classes\Messaging\SMS\Extensions\Drivers\Smart;
use SimpleSoftwareIO\SMS\DriverManager as BaseDriverManager;

class DriverManager extends BaseDriverManager
{
    /**
     * Create an instance of the telerivet driver
     *
     * @return Telerivet
     */
    public function createTelerivetDriver(){
        $config = $this->app['config']->get('sms.telerivet', []);
        $driver = new Telerivet($config['api_key'], $config['project_id']);

        return $driver;
    }

    /**
     * Create an instance of the smart driver
     *
     * @return Telerivet
     */
    public function createSmartDriver(){
        $config = $this->app['config']->get('sms.smart', []);
        $driver = new Smart($config['token'], $config['wsdl'], $config['service']);

        return $driver;
    }
}