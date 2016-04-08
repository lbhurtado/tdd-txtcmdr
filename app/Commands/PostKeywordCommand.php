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

    public $keyword;

    public $arguments;

    /**
     * PostKeywordCommand constructor.
     * @param $mobile
     * @param $keyword
     * @param $arguments
     */
    public function __construct($mobile, $keyword, $arguments = null)
    {
        $this->mobile = $mobile;

        $this->keyword = $keyword;

        $this->arguments = $arguments;
    }

}