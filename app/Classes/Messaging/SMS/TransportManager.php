<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 03/04/16
 * Time: 07:30
 */

namespace App\Classes\Messaging\SMS;

use Illuminate\Support\Manager;
use Psr\Log\LoggerInterface;

class TransportManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['sms.driver'];
    }

    /**
     * Create an instance of the Log Transport driver
     *
     * @return LogTransport
     */
    protected function createLogDriver()
    {
        return new LogTransport($this->app->make(LoggerInterface::class));
    }

    /**
     * Create an instance of the Telerivet Transport driver
     *
     * @return TelerivetTransport
     */
    protected function createTelerivetDriver()
    {
//        $config = $this->app['config']->get('sms.telerivet', []);

        return new TelerivetTransport();
    }

    /**
     * Create an instance of the Smart Transport driver
     *
     * @return SmartTransport
     */
    protected function createSmartDriver()
    {
//        $config = $this->app['config']->get('sms.smart', []);

        return new SmartTransport();
    }
}