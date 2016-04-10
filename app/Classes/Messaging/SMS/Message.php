<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 01/04/16
 * Time: 11:52
 */

namespace App\Classes\Messaging\SMS;

use Illuminate\View\Factory;
use Illuminate\Support\Facades\App;

class Message
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $content;

    /**
     * @var array
     */
    private $to = [];

    /**
     * @var string
     */
    private $subject;

    /**
     * @var bool
     */
    private $sent = false;

    /**
     * The Illuminate view factory.
     *
     * @var \Illuminate\View\Factory
     */
    protected $views;

    /**
     * @param $template
     * @param array $content
     */
    public function __construct($template, array $content)
    {
        $this->template = $template;
        $this->content  = $content;
        $this->views = App::make(Factory::class);
    }

    /**
     * Composes a message.
     *
     * @return \Illuminate\View\Factory
     */
    public function composeMessage()
    {
        // Attempts to make a view.
        // If a view can not be created; it is assumed that simple message is passed through.
        try
        {
            return $this->views->make($this->template, $this->content)->render();
        }
        catch (\InvalidArgumentException $e)
        {
            return $this->view;
        }
    }

    /**
     * Set the `to` field
     *
     * @param string $mobile
     * @return $this
     * @internal param string $name
     */
    public function to($mobile)
    {
        $this->to[] = array_merge(compact('mobile'), ['type' => 'to']);

        return $this;
    }

    /**
     * Set the subject
     *
     * @param string $subject
     * @return void
     */
    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Mark the Message as sent
     *
     * @return void
     */
    public function sent()
    {
        $this->sent = true;

        return $this;
    }

    /**
     * Check to see if the Message has been sent
     *
     * @return bool
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * Return the Message as an array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'template' => $this->template,
            'subject'  => $this->subject,
            'to'       => $this->to,
            'content'  => $this->content
        ];
    }

    /**
     * Retrieve private attributes
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
    }
}