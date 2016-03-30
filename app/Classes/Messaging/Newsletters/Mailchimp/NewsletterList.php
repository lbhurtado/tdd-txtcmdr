<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 30/03/16
 * Time: 08:22
 */

namespace App\Classes\Messaging\Newsletters\Mailchimp;


use App\Classes\Messaging\Newsletters\NewsletterList as NewsletterListInterface;
use Mailchimp;

class NewsletterList implements NewsletterListInterface
{
    /**
     * @var
     */
    protected $mailchimp;

    protected $lists = [
        'initialSubscribers' => "b14ec1e715"
    ];

    /**
     * @param Mailchimp $mailchimp
     */
    public function __construct(Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    /**
     * Subscribe a user to a Mailchimp list
     *
     * @param $listName
     * @param $email
     * @return mixed
     */
    public function subscribeTo($listName, $email)
    {
        return $this->mailchimp->lists->subscribe(
            $this->lists[$listName],
            ['email' => $email],
            null, // merge mergeVars
            'html', // email type
            false, // double opt-in
            true // update existing customer
        );
    }

    /**
     * @param $list
     * @param $email
     * @return mixed
     */
    public function unsubscribeFrom($listName, $email)
    {
        return $this->mailchimp->lists->unsubscribe(
            $this->lists[$listName],
            ['email' => $email],
            false, // delete the member permanently
            false, // send goodbye email
            false // send unsubscribe notification email
        );
    }

}