<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\get;

it('cannot be accessed by a guest', function () {
    $course = Course::factory()->create();

    get(route('pages.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    loginAsUser();
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);

});

it('shows first course video by default', function () {
    $course = Course::factory()
        ->has(Video::factory()->state(['title' => 'My Video']))
        ->create();

    loginAsUser();
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeText('My Video');
});

it('shows provided course video', function () {
    $course = Course::factory()
        ->has(
            Video::factory()
                ->state(
                    new Sequence(
                        ['title' => 'First video'],
                        ['title' => 'Second video']
                    ))
                ->count(2)
        )
        ->create();

    loginAsUser();
    get(route('pages.course-videos', [
        'course' => $course,
        'video' => $course->videos()->orderByDesc('id')->first(),
    ]))
        ->assertOk()
        ->assertSeeText('Second video');
});
