<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\Locales\Cluster;
use App\Events\TokenFromMissiveMatchedPattern;

class RegisterMobile extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $mobile;

    protected $body;

    /**
     * RegisterMobile constructor.
     * @param $body
     * @param $mobile
     */
    public function __construct($mobile, $body)
    {
        $this->body = $body;
        $this->mobile = $mobile;
    }

    public function handle(UserRepositoryInterface $userRepository)
    {
        $user = $userRepository->register($this->mobile, null); // update null to handle

        $userIsRegistered = (bool) $user;

        if ($userIsRegistered)
            $this->processMessage();
    }

    protected function processMessage()
    {
        $tokenMatchedPattern = preg_match(Cluster::$token_pattern, $this->body);

        if ($tokenMatchedPattern)
            event(new TokenFromMissiveMatchedPattern($this->mobile, $this->body));

        $keywordClasses = getKeywordClasses();

        $classes = [];

        foreach ($keywordClasses as $keywordClass)
        {
            $obj = \App::make($keywordClass);

            $classes[] = $keywordClass::getPattern();
//            if (preg_match($obj->getPattern(), $this->body, $matches))
//            {
//                $classes[] = strtolower($obj->getKeyword());
//            }
        }

        dd($classes);

//        $classes = [];
//
//        foreach($keywordClasses as $keywordClass)
//        {
//            $keywordObject = (new \ReflectionClass($keywordClass))->newInstance();
//
//            $classes[] = strtolower($keywordObject->getKeyword());
//        }
//
//        $regexKeywordClasses = "/^#?(?<keyword>" . implode("|", $classes) . ")\s*(?<arguments>.*)$/i";
//
//        dd($regexKeywordClasses);
    }
}
