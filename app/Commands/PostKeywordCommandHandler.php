<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 06/04/16
 * Time: 15:29
 */

namespace App\Commands;

use App\Classes\Commanding\CommandHandler;
use App\Classes\Watcher;
use App\Classes\Repositories\Interfaces\PostRepositoryInterface;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
//use App\Commands\Keywords\Start;
use Symfony\Component\Finder\Finder;
use hanneskod\classtools\Iterator\ClassIterator;
use App\Commands\Keywords\Keyword;

class PostKeywordCommandHandler extends CommandHandler
{
    function getKeywordClasses()
    {
        $path = app_path();

        $ns = (new \ReflectionClass(Keyword::class))->getNamespaceName();

        $finder = new Finder();

        $iterator = new ClassIterator($finder->files()->in($path));

        $result = [];

        foreach ($iterator->inNamespace($ns)->type(Keywords\Keyword::class)->where('isInstantiable') as $class)
        {
            $result[] = $class->getName();
        }

        return $result;
    }

    public function handle($command)
    {
        $user = \App::make(UserRepositoryInterface::class)->find($command->mobile);

        if ( !is_null($user) )
        {
            $keywordClasses = $this->getKeywordClasses();

            foreach ($keywordClasses as $keywordClass) {

                $obj = \App::make($keywordClass);

                if (preg_match($obj->getPattern(), $command->keyword, $matches))
                {
                    $post = \App::make(PostRepositoryInterface::class)->firstOrNew(
                        [
                            'title' => $matches['tag'],
                            'body' => $matches['message'] ?: "empty",
                        ]);

                    $post->user()->associate($user);

                    $post->save();

                    return true;
                }
            }

        }
    }

}