<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Classes\Messaging\SMS\Message;

class MessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function should_mark_message_as_sent()
    {
        $message = new Message('template', ['name' => 'John']);

        $message->sent();

        $this->assertTrue($message->isSent());
    }

    /** @test */
    public function should_add_subject()
    {
        $message = new Message('template', ['name' => 'John']);

        $message->subject('subject');

        $this->assertEquals('subject', $message->subject);
    }

    /** @test */
    public function should_add_to_mobile()
    {
        $message = new Message('template', ['body' => 'The quick brown fox...']);

        $message->to('639189362340');

        $this->assertEquals([['mobile' => '639189362340', 'type' => 'to']], $message->to);
    }

    /** @test */
    public function should_return_message_as_array()
    {
        $message = new Message('template', ['body' => 'The quick brown fox...']);

        $message->subject('subject');

        $message->to('639189362340');

        $this->assertEquals(
            [
                'template' => 'template',
                'subject'  => 'subject',
                'to'       => [
                    [
                        'mobile' => '639189362340',
                        'type' => 'to'
                    ]
                ],
                'content'  =>
                    [
                        'body' => 'The quick brown fox...'
                    ]
            ],
            $message->toArray());
    }
}
