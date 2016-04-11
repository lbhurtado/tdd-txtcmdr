<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 11/04/16
 * Time: 19:19
 */

namespace App\Commands\Keywords;


class InvokeStartKeyword extends KeywordJob
{
    protected static $keywords = ['start', 'ready'];
}