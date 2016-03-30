<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 30/03/16
 * Time: 08:18
 */

namespace App\Classes\Messaging\Newsletters;


interface NewsletterList
{
    /**
     * @param $listName
     * @param $email
     * @return mixed
     */
    public function subscribeTo($listName, $email);

    /**
     * @param $list
     * @param $email
     * @return mixed
     */
    public function unsubscribeFrom($list, $email);
}