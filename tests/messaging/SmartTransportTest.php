<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Messaging\SMS\SmartTransport;
use App\Classes\Messaging\SMS\Message;

class SmartTransportTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function smart_transport_should_send_message()
    {

    }
}
