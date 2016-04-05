<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Commands\PostMissiveCommand;
use App\Classes\Commanding\ValidationCommandBus;

class CommandTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function post_missive_command_test()
    {
        $command = new PostMissiveCommand('09189362340', 'Yes, yes, yo');

        $commandBus =  App::make(ValidationCommandBus::class);

        $commandBus->execute($command);

        $missive = App::make(App\Classes\Repositories\MissiveRepositoryInterface::class);

        $this->assertCount(1, $missive->getAll());
    }
}
