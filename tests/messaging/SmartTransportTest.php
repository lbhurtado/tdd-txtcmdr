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
        $message = (new Message('template',
            [
            'header' => "Header",
            'body' => "Testing multiple addressees - Globe muna. 2",
            'footer' => "Footer"
            ]
        ))->to('Globe', '09173011987')->to('Smart', '09189362340');

        $transport = new SmartTransport();

        $message = $transport->send($message);

        $this->assertTrue($message->isSent());
    }
}
