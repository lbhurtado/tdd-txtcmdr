<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Missive;
use App\Classes\User;
use App\Classes\Post;
use App\Classes\Watcher;
use App\Classes\Group;
use App\Commands\PostMissiveCommand;
use App\Classes\Commanding\ValidationCommandBus;

class UserMissivesTest extends TestCase
{
    use DatabaseTransactions;

    private $commandBus;

    protected function setUp()
    {
        parent::setUp();

        $this->commandBus =  App::make(ValidationCommandBus::class);

//        Missive::create([
//            'mobile' => "09181234567",
//            'body' => "GETHSEMANE"
//        ]);
    }

    /** @test */
    function a_missive_can_auto_create_a_user_exclusive_from_watcher()
    {
//        $command = new PostMissiveCommand('09189362340', "GETHSEMANE");
//
//        $this->commandBus->execute($command);
//
//        $this->assertEquals('639181234567', User::find(1)->mobile);
//
//        $this->assertEmpty(Watcher::find(1));
//
//        $this->assertEmpty(Post::find(1));

        $command = new PostMissiveCommand('09189362340', 'Yes, yes, yo');

        $this->commandBus->execute($command);

        $user = App::make(\App\Classes\Repositories\Interfaces\UserRepositoryInterface::class);

        $this->assertCount(1, $user->getAll());

        $this->assertEquals('639189362340', $user->find('09189362340')->mobile);

        $this->assertEquals('639189362340', $user->find('09189362340')->handle);
    }

    /** @test */
    function a_missive_can_auto_join_a_user_to_a_group()
    {
//        $this->assertNotEmpty(Group::find(1));
//        $this->assertEquals('639181234567', Group::whereName("Gethsemane Parish")->firstOrFail()->members()->find(1)->mobile);
    }

}
