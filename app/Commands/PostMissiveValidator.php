<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 06/04/16
 * Time: 07:33
 */

namespace App\Commands;

use Illuminate\Support\Facades\Validator;

class PostMissiveValidator
{
    static $rules = [
        'mobile' => array('required', "regex: /^(?<country>0|63|\+63)(?<telco>9\d{2})(?<number>\d{7})$/"),
        'body' => 'required'
    ];

    public function validate($command) {
        $validator = Validator::make(
            [
                'mobile' => $command->mobile,
                'body' => $command->body
            ],
            self::$rules
        );

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }
    }
}