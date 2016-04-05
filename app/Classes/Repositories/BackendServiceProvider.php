<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 07:56
 */

namespace App\Classes\Repositories;

use App\Classes\Repositories\Interfaces\MissiveRepositoryInterface;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\Repositories\Interfaces\WatcherRepositoryInterface;
use App\Classes\Repositories\Interfaces\PostRepositoryInterface;

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
            DbMissiveRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            DbUserRepository::class
        );

        $this->app->bind(
            WatcherRepositoryInterface::class,
            DbWatcherRepository::class
        );

        $this->app->bind(
            PostRepositoryInterface::class,
            DbPostRepository::class
        );
    }

}