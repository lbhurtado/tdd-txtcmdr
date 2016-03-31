<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 31/03/16
 * Time: 08:26
 */

namespace App\Classes\Messaging\Mailers;

use Illuminate\Support\ServiceProvider;

class UserMailerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Mailer::class,
            UserMailer::class
        );
    }

}