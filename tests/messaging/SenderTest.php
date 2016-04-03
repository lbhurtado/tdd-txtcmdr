<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
use App\Classes\Messaging\SMS\Facades\SMS;
use App\Classes\Messaging\SMS\Sender;
use App\Classes\Messaging\SMS\Message;
use Carbon\Carbon;

class SenderTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function sender_should_have_a_transport()
    {
        $transport = m::mock(App\Classes\Messaging\SMS\Transport::class);

        $transport->shouldReceive('send')->once();

        $sender = new Sender($transport);

        $message = new Message('template', []);

        $sender->send($message);

        $this->assertEquals($transport, $sender->getTransport());
    }

    /** @test  */
    function sms_facade_should_send_message()
    {
        $template = 'sms.testing.transport';
        $content = [
            'header' => "Text Commander",
            'body' => "Testing " . __METHOD__,
            'footer' => Carbon::now('Asia/Manila')
        ];
        $message = (new Message($template, $content))
            ->to('Globe', '09173011987')
            ->to('Smart', '09189362340');

        SMS::send($message);

        $this->assertTrue($message->isSent());
    }
}
