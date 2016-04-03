<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 03/04/16
 * Time: 07:46
 */

namespace App\Classes\Messaging\SMS;


use Illuminate\Support\ServiceProvider;

class SenderServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sender', function ($app) {
            $manager = new TransportManager($app);

            return new Sender($manager->driver());
        });
    }

}