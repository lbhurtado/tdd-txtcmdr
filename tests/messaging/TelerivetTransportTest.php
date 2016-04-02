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
        $message = (new Message('template',
            [
            'header' => "Header",
            'body' => "Testing Telerivet from Laravel " . Carbon::now('Asia/Manila'),
            'footer' => "Footer"
            ]
        ))->to('Globe', '09173011987')->to('Smart', '09189362340');

        $transport = new TelerivetTransport();

        $result = $transport->send($message);

        $this->assertEquals(2, $result['count_queued']);
    }
}
