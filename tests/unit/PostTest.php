<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Post;
use App\Classes\User;
use App\Classes\Locales\Cluster;
use App\Classes\Watcher;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_post_has_a_title_body_user_id()
    {
        $user = factory(User::class)->create(['name'=>"John"]);

        $post = (new Post([
            'title' => "Some Title",
            'body' => "Some Body",
        ]))->user()->associate($user);

        $post->save();

        $post = (new Post([
            'title' => "Some Title 2",
            'body' => "A Body the second time",
        ]))->user()->associate($user);

        $post->save();

        $this->assertEquals('Some Title 2', $post->title);
    }

    /** @test */
    function a_watcher_can_post()
    {
        $watcher = factory(Watcher::class)->create();

        $post = factory(Post::class)->create(['title' => "Some Title"]);

        $post->user()->associate($watcher->user);

        $post->save();

        $this->assertEquals('Some Title', $post->title);
    }
}
