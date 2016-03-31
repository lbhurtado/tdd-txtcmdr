<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\User;
use App\Classes\Messaging\Mailers\UserMailer;
use Illuminate\Support\Facades\App;

class EmailTest extends TestCase
{
    use DatabaseTransactions, MailTracking;

    private $mailer;

    public function setUp()
    {
        parent::setUp();

        $this->mailer = App::make(UserMailer::class);
    }

    /** @test */
    public function testBasicEmail()
    {
        Mail::raw('Hello world', function($email){
            $email->to('foo@bar.com');
            $email->from('bar@foo.com');

        });

        Mail::raw('Hello world', function($email){
            $email->to('foo@bar.com');
            $email->from('bar@foo.com');

        });

        $this->seeEmailContains("Hello");
//        $this->seeEmailsSent(2);
//
//        $this->seeEmailTo("foo@bar.com")
//            ->seeEmailFrom("bar@foo.com");
    }

    /** @test */
    public function testUserMailer()
    {
        $user = factory(User::class)->create(['email' => "lbhurtado@me.com"]);

        $this->mailer->sendWelcomeMessageTo($user);

        $this->seeEmailTo("lbhurtado@me.com")
             ->seeEmailContains("si vis pacem para bellum");
    }
}
