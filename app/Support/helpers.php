<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 08/04/16
 * Time: 17:55
 */

use Symfony\Component\Finder\Finder;
use hanneskod\classtools\Iterator\ClassIterator;
use App\Commands\Keywords\Keyword;

define('DEFAULT_COUNTRY_CODE', "63");

define('MOBILE_REGEX', "/^(?<country>0|63|\+63)(?<telco>9\d{2})(?<number>\d{7})$/");

function formalizeMobile($mobile)
{
    if (preg_match(MOBILE_REGEX, $mobile, $matches))
        $mobile = DEFAULT_COUNTRY_CODE . $matches['telco'] . $matches['number'];

    return $mobile;
}

function getKeywordClasses()
{
    $path = app_path();

    $ns = (new \ReflectionClass(Keyword::class))->getNamespaceName();

    $finder = new Finder();

    $iterator = new ClassIterator($finder->files()->in($path));

    $result = [];

//    foreach ($iterator->inNamespace($ns)->type(App\Commands\Keywords\Keyword::class)->where('isInstantiable') as $class)
    foreach ($iterator->inNamespace($ns)->where('isInstantiable') as $class)
    {
        $result[] = $class->getName();
    }

    return $result;
}