<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
use App\Classes\Messaging\SMS\Sender;
use App\Classes\Messaging\SMS\Message;
use Carbon\Carbon;

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

    /** @test  */
    function driver_should_send_message()
    {
        $message =
            ( new Message
            (
                'sms.testing.transport',
                [
                    'header' => "Text Commander",
                    'body' => "Testing " . __METHOD__ ,
                    'footer' => Carbon::now('Asia/Manila')
                ]
            ))
                ->to('Globe', '09173011987')
                ->to('Smart', '09189362340');

        $sender = $this->app->make(Sender::class);

        $sender->send($message);

        $this->assertTrue($message->isSent());
    }
}
