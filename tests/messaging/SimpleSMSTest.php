<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SimpleSMSTest extends TestCase
{
    /** @test */
    function send_test()
    {
        SMS::send('This is my message', [], function($sms) {
            $sms->to('09189362340');
        });
    }
}
