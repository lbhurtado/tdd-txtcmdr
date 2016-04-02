<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 01/04/16
 * Time: 11:52
 */

namespace App\Classes\Messaging\SMS;


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
     * @param string $template
     * @param array $content
     * @return void
     */
    public function __construct($template, array $content)
    {
        $this->template = $template;
        $this->content  = $content;
    }

    /**
     * Set the `to` field
     *
     * @param string $name
     * @param string $email
     * @return void
     */
    public function to($name, $mobile)
    {
        $this->to[] = array_merge(compact('name', 'mobile'), ['type' => 'to']);
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
    }

    /**
     * Mark the Message as sent
     *
     * @return void
     */
    public function sent()
    {
        $this->sent = true;
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