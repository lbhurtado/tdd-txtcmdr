{{ $event->user->name }} published a post <a href="/posts/{{ $event->subject->id }}">{{$event->subject->title }}</a> {{ $event->created_at->diffForHumans() }}