<?php

namespace App\Console\Commands;

use App\Classes\Messaging\Notifications\LessonPublished;
use Illuminate\Console\Command;

class LessonPublishedNotifierCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applester:notify-lesson-subscriber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all lesson subscribers by email.';

    /**
     * @var LessonPublished
     */
    private $lessonPublishedNotifier;

    /**
     * @param LessonPublished $lessonPublishedNotifier
     */
    public function __construct(LessonPublished $lessonPublishedNotifier)
    {
        parent::__construct();

        $this->lessonPublishedNotifier = $lessonPublishedNotifier;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lesson = $this->getLesson();

        $this->lessonPublishedNotifier->notify($lesson['title'], $lesson['body']);
    }

    /**
     * @return array
     */
    private function getLesson()
    {
        return [
            'title' => "My Lesson Title",
            'body' => "The body of my lesson."
        ];
    }
}
