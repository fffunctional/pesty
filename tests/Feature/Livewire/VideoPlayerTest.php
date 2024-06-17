<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

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

it('shows list of all course videos', function () {
    $course = Course::factory()
        ->has(Video::factory()
        ->count(3)
    )->create();

    Livewire::test(VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSee([
            ...$course->videos->pluck('title')->toArray()
        ])->assertSeeHtml([
            route('pages.course-videos', $course->videos[0]),
            route('pages.course-videos', $course->videos[1]),
            route('pages.course-videos', $course->videos[2]),
        ]);
});

it('marks video as completed', function () {
   $user = User::factory()->create();
   $course = Course::factory()
       ->has(Video::factory())
       ->create();

   $user->purchasedCourses()->attach($course);

   expect($user->watchedVideos)->toHaveCount(0);

   loginAsUser($user);
   Livewire::test(VideoPlayer::class, ['video' => $course->videos->first()])
       ->call('markVideoAsCompleted');

   $user->refresh();
   expect($user->watchedVideos)
       ->toHaveCount(1)
       ->first()->title->toEqual($course->videos->first()->title);
});

it('marks video as not completed', function () {
    $user = User::factory()->create();
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    $user->purchasedCourses()->attach($course);
    $user->watchedVideos()->attach($course->videos->first());

    expect($user->watchedVideos)->toHaveCount(1);

    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->call('markVideoAsNotCompleted');

    $user->refresh();
    expect($user->watchedVideos)
        ->toHaveCount(0);
});
