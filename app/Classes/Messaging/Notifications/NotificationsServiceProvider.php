<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 30/03/16
 * Time: 13:51
 */

namespace App\Classes\Messaging\Notifications;

use App\Classes\Messaging\Notifications\LessonPublished;
use App\Notifications\Mailchimp;
use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            LessonPublished::class,
            \App\Classes\Messaging\Notifications\Mailchimp\LessonPublished::class
        );
    }

}