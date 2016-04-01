<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;
use App\Classes\Messaging\SMS\LogTransport;
use App\Classes\Messaging\SMS\Message;

class LogTransportTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function should_send_message()
    {
        $logger = m::mock(Psr\Log\LoggerInterface::class);

        $logger->shouldReceive('debug')->once();

        $transport = new LogTransport($logger);
        $message = $transport->send(new Message('template', []));

        $this->assertTrue($message->isSent());
    }
}
