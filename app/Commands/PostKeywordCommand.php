<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 06/04/16
 * Time: 15:23
 */

namespace App\Commands;


class PostKeywordCommand
{
    public $mobile;

    public $body;

    /**
     * PostKeywordCommand constructor.
     * @param $body
     * @param $mobile
     */
    public function __construct($mobile, $body)
    {
        $this->mobile = $mobile;

        $this->body = $body;
    }

}