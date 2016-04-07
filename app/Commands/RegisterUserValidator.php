<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 07/04/16
 * Time: 09:20
 */

namespace App\Commands;

use Illuminate\Support\Facades\Validator;

class RegisterUserValidator
{
    static $rules = [
        'mobile' => array("required","regex: /^(?<country>0|63|\+63)(?<telco>9\d{2})(?<number>\d{7})$/"),
        'token' => 'required'
    ];

    public function validate($command)
    {
        $validator = Validator::make(
            [
                'mobile' => $command->mobile,
                'token' => $command->token
            ],
            self::$rules
        );

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }
    }
}