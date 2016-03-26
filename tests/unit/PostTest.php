<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\User;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_post_has_a_title_body_user_id() {

        $user = factory(User::class)->create(['name'=>"John"]);

        $post = Post::create([
            'title' => "Some Title",
            'body' => "Some Body",
            'user_id' => $user->id
        ]);

        $post = Post::create([
            'title' => "Some Title 2",
            'body' => "A Body the second time",
            'user_id' => $user->id
        ]);

        $this->assertEquals('Some Title 2', $post->title);
    }

}
