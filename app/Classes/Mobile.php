<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 14/04/16
 * Time: 23:18
 */

namespace App\Classes;

use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumberFormat;

class Mobile
{
    protected $number;

    public function __construct($number)
    {
        $validator = Validator::make(compact('number'), ['number' => 'phone:AUTO,PH']);

        if ($validator->fails())
        {
            throw new \Exception('Invalid phone number!');
        }

        $this->number = phone_format($number, 'PH', PhoneNumberFormat::INTERNATIONAL);
    }

    public function internationalNumber()
    {
        return phone_format($this->number, 'PH', PhoneNumberFormat::INTERNATIONAL);
    }

    public function nationalNumber()
    {
        return phone_format($this->number, 'PH', PhoneNumberFormat::NATIONAL);
    }
}