<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
use App\Classes\Messaging\SMS\Sender;
use App\Classes\Messaging\SMS\Message;

class SenderTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function should_send_message()
    {
        $transport = m::mock(App\Classes\Messaging\SMS\Transport::class);
        $transport->shouldReceive('send')->once();

        $mailer = new Sender($transport);
        $mailer->send(new Message('template', []));
    }
}
