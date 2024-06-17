<div>
    <iframe src="https://player.vimeo.com/video/{{$video->vimeo_id}}"></iframe>
    <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
    <p>{{ $video->description }}</p>
    <ul>
        @foreach($courseVideos as $courseVideo)
            <a href="{{ route('pages.course-videos', $courseVideo) }}">
                {{ $courseVideo->title }}
            </a>
        @endforeach
    </ul>
</div>

