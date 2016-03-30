<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 30/03/16
 * Time: 11:26
 */

namespace App\Classes\Messaging\Newsletters;

use App\Classes\Messaging\Newsletters\NewsletterList;
use App\Newsletters\Mailchimp;
use Illuminate\Support\ServiceProvider;

class NewsletterListServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            NewsletterList::class,
            \App\Classes\Messaging\Newsletters\Mailchimp\NewsletterList::class
        );
    }

}