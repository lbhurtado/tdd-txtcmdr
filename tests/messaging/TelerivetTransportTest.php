<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Messaging\SMS\TelerivetTransport;
use App\Classes\Messaging\SMS\Message;
use Carbon\Carbon;

class TelerivetTransportTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function telerivet_transport_should_send_message()
    {
        $message =
            ( new Message
            (
                'sms.testing.transport',
                [
                    'header' => "Header",
                    'body' => "Testing Telerivet API from Laravel " . Carbon::now('Asia/Manila'),
                    'footer' => "Lester"
                ]
            ))
                ->to('Globe', '09173011987')
                ->to('Smart', '09189362340');

        $result = (new TelerivetTransport())->send($message);

        $this->assertTrue($message->isSent());
    }
}
