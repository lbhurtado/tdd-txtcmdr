<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Messaging\SMS\TelerivetTransport;
use App\Classes\Messaging\SMS\Message;
use App\Classes\Messaging\SMS\Sender;
use Carbon\Carbon;

class TelerivetTransportTest extends TestCase
{
    use DatabaseTransactions;

    private $api_key;

    private $project_id;

    function setUp()
    {
        parent::setUp();

        $this->api_key = env('TELERIVET_API_KEY');

        $this->project_id = env('TELERIVET_PROJECT_ID');
    }

    /** @test */
    public function telerivet_transport_should_send_message()
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

        $telerivet = new TelerivetTransport($this->api_key, $this->project_id);

        $msg = $telerivet->send($message);

        $this->assertTrue($message->isSent());

        $this->assertEquals($message, $msg);
    }
}
