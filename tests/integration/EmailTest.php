<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailTest extends TestCase
{
    use DatabaseTransactions, MailTracking;

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

        $this->seeEmailContains("Yo");
//        $this->seeEmailsSent(2);
//
//        $this->seeEmailTo("foo@bar.com")
//            ->seeEmailFrom("bar@foo.com");
    }
}
