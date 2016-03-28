<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\User;
use App\Cluster;
use App\Watcher;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_post_has_a_title_body_user_id() {

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
    function a_watcher_can_post() {
        $cluster = Cluster::create();

        $watcher = Watcher::autoDesignate($cluster->token, [
            'mobile' => "09189362340",
            'handle' => "lbhurtado"
        ]);

        $post = (new Post([
            'title' => "Some Title",
            'body' => "Some Body",
        ]))->user()->associate($watcher->user);

        $post->save();

        $this->assertEquals('Some Title', $post->title);
    }
}
