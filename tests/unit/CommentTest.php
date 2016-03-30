<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Comment;
use App\Classes\User;
use App\Classes\Post;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_comment_has_a_body_user_id() {

        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id' => $user->id]);


        $comment = Comment::create([
            'body' => "Some Body",
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);


        $this->assertEquals('Some Body', $comment->body);
    }
}
