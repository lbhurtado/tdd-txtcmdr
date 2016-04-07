<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 06/04/16
 * Time: 10:54
 */

namespace App\Commands;


class RegisterUserCommand
{
    public $mobile;

    public $token;

    /**
     * RegisterUserCommand constructor.
     * @param $mobile
     * @param $token
     */
    public function __construct($mobile, $token)
    {
        $this->mobile = $mobile;

        $this->token = $token;
    }
}