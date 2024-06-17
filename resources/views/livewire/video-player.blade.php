<div>
    <iframe src="https://player.vimeo.com/video/{{$video->vimeo_id}}"></iframe>
    <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
    <p>{{ $video->description }}</p>
    @if(auth()->user()?->watchedVideos()->where('video_id', $video->id)->count())
    <button wire:click="markVideoAsNotCompleted">Mark as completed</button>
    @else
    <button wire:click="markVideoAsCompleted">Mark as not completed</button>
    @endif
    <ul>
        @foreach($courseVideos as $courseVideo)
        <li>
            @if($this->isCurrentVideo($courseVideo))
                {{ $courseVideo->title }}
            @else
            <a href="{{ route('pages.course-videos', $courseVideo) }}">
                {{ $courseVideo->title }}
            </a>
            @endif
        </li>
        @endforeach
    </ul>
</div>

