<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 04/04/16
 * Time: 19:03
 */

namespace App\Events;

use App\Classes\Missive;
use Illuminate\Queue\SerializesModels;

class MissiveWasPosted
{
    use SerializesModels;

    /**
     * @var
     */
    public $missive;

    /**
     * @param Missive $missive
     */
    public function __construct(Missive $missive)
    {
        $this->missive = $missive;
    }


}