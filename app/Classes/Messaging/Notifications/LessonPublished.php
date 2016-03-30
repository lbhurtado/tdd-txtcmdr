<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 30/03/16
 * Time: 11:32
 */

namespace App\Classes\Messaging\Notifications;


interface LessonPublished
{
    /**
     * @param $title
     * @param $body
     * @return mixed
     */
    public function notify($title, $body);
}