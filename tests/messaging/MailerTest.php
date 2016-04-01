<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
use App\Classes\Messaging\SMS\Mailer;
use App\Classes\Messaging\SMS\Message;

class MailerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function should_send_message()
    {
        $transport = m::mock(App\Classes\Messaging\SMS\Transport::class);
        $transport->shouldReceive('send')->once();

        $mailer = new Mailer($transport);
        $mailer->send(new Message('template', []));
    }
}
