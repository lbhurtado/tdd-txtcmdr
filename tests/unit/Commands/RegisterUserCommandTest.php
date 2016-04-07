<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Commanding\ValidationCommandBus;
use App\Commands\RegisterUserCommand;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\Locales\Cluster;


class RegisterUserCommandTest extends TestCase
{
    use DatabaseTransactions;

    private $commandBus;

    protected function setUp()
    {
        parent::setUp();

        $this->commandBus =  App::make(ValidationCommandBus::class);
    }

    /** @test */
    function a_register_user_command_has_empty_mobile_validation()
    {
        $command = new RegisterUserCommand("", "asdsd");

        $this->setExpectedException('Exception');

        $this->commandBus->execute($command);
    }

    /** @test */
    function a_register_user_command_has_regex_mobile_validation()
    {
        $command = new RegisterUserCommand("021321323", "asdsd");

        $this->setExpectedException('Exception');

        $this->commandBus->execute($command);
    }

    /** @test */
    function a_register_user_command_has_empty_token_validation()
    {
        $command = new RegisterUserCommand("09189362340", "");

        $this->setExpectedException('Exception');

        $this->commandBus->execute($command);
    }

    /** @test */
    function a_register_user_command_creates_a_user()
    {
        $command = new RegisterUserCommand("09189362340", "asdas");

        $this->commandBus->execute($command);

        $user = App::make(UserRepositoryInterface::class);

        $this->assertCount(1, $user->getAll());

        $this->assertEquals('639189362340', $user->find('09189362340')->mobile);

        $this->assertEquals('639189362340', $user->find('09189362340')->handle);
    }

    /** @test */
    function a_register_user_command_creates_a_watcher()
    {
        Cluster::create();

        $token = Cluster::find(1)->token;

        $command = new RegisterUserCommand('09189362340', $token);

        $this->commandBus->execute($command);

        $watcher = App::make(\App\Classes\Repositories\Interfaces\WatcherRepositoryInterface::class);

        $this->assertCount(1, $watcher->getAll());

        $this->assertEquals('639189362340', $watcher->find('09189362340')->user->mobile);

        $this->assertEquals('639189362340', $watcher->find('09189362340')->user->handle);
    }
}
