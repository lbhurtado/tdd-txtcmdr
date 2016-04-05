<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 9/27/15
 * Time: 19:57
 */

namespace App\Listeners;

use App\Events\OTPWasGenerated;
use App\Events\PINWasConfirmed;
use App\Events\LoadWasPosted;
use App\Events\SurveyWasPosted;
use App\Events\ResponseWasPosted;
use App\Events\ResponseWasUpdated;
use App\Events\ResponseWasDuplicated;
use App\Events\PassageWasPosted;

class VarDump extends Listener
{
    public function whenOTPWasGenerated(OTPWasGenerated $event)
    {
        var_dump($event);
    }

    public function whenPINWasConfirmed(PINWasConfirmed $event)
    {
        var_dump($event);
    }

    public function whenLoadWasPosted(LoadWasPosted $event)
    {
        var_dump($event);
    }

    public function whenSurveyWasPosted(SurveyWasPosted $event)
    {
        var_dump($event);
    }

    public function whenResponseWasPosted(ResponseWasPosted $event)
    {
        var_dump($event);
    }

    public function whenResponseWasUpdated(ResponseWasUpdated $event)
    {
        var_dump($event);
    }

    public function whenResponseWasDuplicated(ResponseWasDuplicated $event)
    {
        var_dump($event);
    }

    public function whenPassageWasPosted(PassageWasPosted $event)
    {
        var_dump($event);
    }
    //always add use when{CLASS} up there
}