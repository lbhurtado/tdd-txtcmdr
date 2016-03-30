<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 30/03/16
 * Time: 12:37
 */

namespace App\Classes\Messaging\Notifications\Mailchimp;

use Mailchimp;
use App\Classes\Messaging\Notifications\LessonPublished as LessonPublishedInterface;

class LessonPublished implements LessonPublishedInterface
{

    /**
     *
     */
    const LESSON_SUBSCRIBER_ID = 'b14ec1e715';

    /**
     * @var Mailchimp
     */
    protected $mailchimp;

    /**
     * LessonPublished constructor.
     * @param $mailchimp
     */
    public function __construct(Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    /**
     * @param $title
     * @param $body
     * @return mixed
     */
    public function notify($title, $body)
    {
        $options = [
            'list_id'       => self::LESSON_SUBSCRIBER_ID,
            'subject'       => "New on Text Commander: " . $title,
            'from_name'     => "Applester Dev't. Corporation",
            'from_email'    => "lester@applester.co",
            'to_name'       => "Applester Subscriber"
        ];

        $content = [
            'html' => $body,
            'text' => strip_tags($body)
        ];

        // Create a new campaign

        $campaign = $this->mailchimp->campaigns->create('regular', $options, $content);

        $this->mailchimp->campaigns->send($campaign['id']);
    }
}