<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Token;
use App\Classes\User;

class TokenTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function a_token_is_automatically_generated_random_4_digit_pin() {
        $token =  factory(Token::class)->create(['pin' => "1234"]);

        $this->assertEquals('1234', $token->pin);

        $token->save();

        $this->seeInDatabase('tokens', ['pin' => "1234"], 'sqlite');

        $token = new Token();

        $this->assertRegExp('/^\\d{4}$/', "{$token->pin}");

        $tokens = factory(Token::class, 2)->create();

        $this->assertNotEquals($tokens->first()->pin, $tokens->last()->pin);
    }

    /** @test */
    function a_token_pin_is_generated_for_a_user() {
        $user = factory(User::class)->create(['name' => "Lester", 'mobile' => "09189362340"]);

        $token = new Token();

        $token->user()->associate($user)->save();

        $this->assertEquals("639189362340", $token->user->mobile);

        $this->seeInDatabase('tokens', ['user_id' => User::where(['name' => "Lester"])->first()->id], 'sqlite');
    }

    /** @test */
    function a_token_can_be_associated_to_a_user() {
        $user = factory(User::class)->create();

        $token1 = factory(Token::class)->create();

        $token2 = factory(Token::class)->create();

        $token1->user()->associate($user)->save();

        $token2->user()->associate($user)->save();

        $this->assertCount(2, $user->tokens);
    }

    /** @test */
    function a_user_can_accept_any_number_of_tokens() {
        $user = factory(User::class)->create();

        $token = factory(Token::class)->create(['pin' => "1111"]);

        $tokens = factory(Token::class,2)->create();

        $user->tokens()->save($token);

        $this->assertCount(1, $user->tokens);

        $this->assertEquals("1111", $user->tokens()->first()->pin);

        $user->tokens()->saveMany($tokens);

        $this->assertEquals(3, $user->tokens()->count());
    }

    /** @test */
    function a_user_can_conjure_tokens() {
        $user = factory(User::class)->create();

        $user->newToken(['pin' => "2222"]);

        $this->assertEquals("2222", $user->tokens()->first()->pin);

        $user->newToken(['pin' => "3333"]);

        $this->assertEquals(2, $user->tokens()->count());
    }

    /** @test */
    function a_token_has_a_context() {
        $token = factory(Token::class)->create(['context' => "context1"]);

        $this->assertEquals("context1", $token->context);
    }
}
