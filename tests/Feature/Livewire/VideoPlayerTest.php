<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;

it('shows details for given video', function () {
    $course = Course::factory()
        ->has(Video::factory())->create();

    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSeeText([
            $video->title,
            $video->description,
            "({$video->duration_in_min}min)",
        ]);
});

it('shows given video', function () {
    $course = Course::factory()
        ->has(Video::factory())->create();

    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSee('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"', false);

});
