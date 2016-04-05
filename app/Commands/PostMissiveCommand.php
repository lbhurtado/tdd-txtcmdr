<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 04/04/16
 * Time: 19:35
 */

namespace App\Commands;


class PostMissiveCommand
{
    public $mobile;

    public $body;

    /**
     * PostMissiveCommand constructor.
     * @param $body
     * @param $mobile
     */
    public function __construct($mobile, $body)
    {
        $this->body = $body;

        $this->mobile = $mobile;
    }


}