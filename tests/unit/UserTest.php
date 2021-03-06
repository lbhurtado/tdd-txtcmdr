<?php

/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 17/03/16
 * Time: 07:33
 */

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\User;

class UserTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    function a_user_has_a_mobile_field_in_international_format_that_is_mass_assignable() {
        $user = factory(User::class)->create([
            'mobile' => "639189362340"
        ]);

        $this->assertEquals("639189362340", $user->mobile);

        $this->seeInDatabase('users', ['mobile' => "639189362340"], 'sqlite');

        User::create([
            'name' =>  "Lester Hurtado",
            'email' => "lester@hurtado.ph",
            'mobile' => "63" . rand(900,999) . rand(1000000, 9999999),
            'password' => "asdsad"
        ]);

        $this->seeInDatabase('users', [
            'name' => "Lester Hurtado",
            'email' => "lester@hurtado.ph"
        ], 'sqlite');
    }

    /** @test */
    function the_user_mobile_field_accepts_national_number_format() {
        $user = factory(User::class)->create([
            'mobile' => "09189362340"
        ]);

        $this->assertEquals("639189362340", $user->mobile);

        $this->seeInDatabase('users', ['mobile' => "639189362340"], 'sqlite');
    }

    /** @test */
    function a_user_has_a_verified_field_that_defaults_to_false() {
        $user = factory(User::class)->create();

        $this->assertFalse($user->verified);
    }

    /** @test */
    function a_user_has_a_token_for_verification_that_defaults_to_a_random_4_digit_number() {
        $user = factory(User::class)->create([
            'token' => "1234"
        ]);

        $this->assertEquals("1234", $user->token);

        $token1 = factory(User::class)->create()->token;

        $token2 = factory(User::class)->create()->token;

        $this->assertNotEquals($token1, $token2);
    }

    /** @test */
    function a_user_has_an_email_field_that_is_optional() {
        $user = factory(User::class)->create([
            'email' => "lester@hurtado.ph"
        ]);

        $this->assertEquals("lester@hurtado.ph", $user->email);

        $user = factory(User::class)->create([
            'email' => null
        ]);

        $this->assertEquals(null, $user->email);
    }

    /** @test */
    function a_user_has_a_userable_property() {
        $user = factory(User::class)->create([
            'mobile' => "639189362340"
        ]);

        $this->assertNotEmpty($user->userable());
    }

    /** @test */
    function the_name_of_the_user_is_optional() {
        $user = User::create(['mobile' => "09189362340"]);

        $this->assertEquals("639189362340", $user->mobile);
    }

    /** @test */
    function the_password_is_a_hash_of_the_last_4_digits_of_the_users_mobile() {
        $user = User::create(['mobile' => "09189362340"]);

        $this->assertTrue(\Hash::check("2340", $user->password));
    }

    /** @test */
    function a_user_has_a_handle_that_defaults_to_the_mobile()
    {
        $user1 = User::create(['mobile' => "09189362340", 'handle' => "lbhurtado"]);

        $this->assertEquals("lbhurtado", $user1->handle);

        $user2 = User::create(['mobile' => "09173011987"]);

        $this->assertEquals("639173011987", $user2->handle);
    }

    /** @test */
    function a_user_has_a_scoped_mobile_attribute() {

        User::create(['mobile' => "09189362340", 'handle' => "lbhurtado"]);

        User::create(['mobile' => "09173011987"]);

        $this->assertEquals("lbhurtado", User::hasMobile('09189362340')->firstOrFail()->handle);

    }
}
