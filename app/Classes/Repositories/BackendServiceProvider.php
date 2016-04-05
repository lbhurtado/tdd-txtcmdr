<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 07:56
 */

namespace App\Classes\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MissiveRepositoryInterface::class,
            DBMissiveRepository::class
        );
    }

}