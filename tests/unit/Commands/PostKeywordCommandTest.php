<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Commanding\ValidationCommandBus;
use App\Commands\PostKeywordCommand;
use App\Classes\Repositories\Interfaces\PostRepositoryInterface;

class PostKeywordCommandTest extends TestCase
{
    use DatabaseTransactions;

    private $commandBus;

    protected function setUp()
    {
        parent::setUp();

        $this->commandBus = App::make(ValidationCommandBus::class);
    }

    /** @test */
    function a_post_keyword_command_has_empty_mobile_validation()
    {
        $command = new PostKeywordCommand("", "keyword");

        $this->setExpectedException('Exception');

        $this->commandBus->execute($command);
    }

    /** @test */
    function a_post_keyword_command_has_regex_mobile_validation()
    {
        $command = new PostKeywordCommand("091", "start");

        $this->setExpectedException('Exception');

        $this->commandBus->execute($command);
    }

    /** @test */
    function a_post_keyword_command_has_empty_key_validation()
    {
        $command = new PostKeywordCommand("09189362340", "");

        $this->setExpectedException('Exception');

        $this->commandBus->execute($command);
    }

    /** @test */
    function a_post_keyword_command_has_regex_validation()
    {
        $command = new PostKeywordCommand('639189362340', "asldas;d");

        $this->setExpectedException('Exception');

        $this->commandBus->execute($command);
    }

    /** @test */
    function a_post_keyword_command_needs_a_user()
    {
        $command = new PostKeywordCommand('09189362340', "here");

        $this->commandBus->execute($command);

        $post = \App::make(PostRepositoryInterface::class);

        $this->assertCount(0, $post->getAll());

        $user = factory(\App\Classes\User::class)->create(['mobile' => '09189362340']);

        $this->commandBus->execute($command);

        $this->assertCount(1, $post->getAll());

        $this->assertEquals('639189362340', $user->mobile);

        $this->assertEquals('639189362340', $post->find(1)->user->mobile);
    }
}
