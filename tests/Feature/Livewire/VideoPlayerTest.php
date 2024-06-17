<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

it('shows details for given video', function () {
   $course = Course::factory()
       ->has(Video::factory()->state([
           'title' => 'Video title',
           'description' => 'Video description',
           'duration' => 10,
       ]))->create();

    Livewire::test(VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSeeText([
           'Video title',
           'Video description',
            '10min'
        ]);
});

it('shows given video', function () {
    $course = Course::factory()
        ->has(Video::factory()->state([
            "vimeo_id" => "vimeo-id",
        ]))->create();

    Livewire::test(VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSee('<iframe src="https://player.vimeo.com/video/vimeo-id', false);

});
