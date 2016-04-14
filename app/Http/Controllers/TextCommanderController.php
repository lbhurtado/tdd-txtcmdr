<?php

namespace App\Http\Controllers;

use App\Classes\Mobile;
use Illuminate\Http\Request;
use libphonenumber\PhoneNumberFormat;

class TextCommanderController extends Controller
{
    public function sms(Mobile $number)
    {
//
//        $this->validate(compact('mobile'), [
//            'mobile' => 'phone:AUTO,PH'
//        ]);

        return $mobile->nationalNumber();

    }
}
