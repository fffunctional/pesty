<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('does not find unreleased course', function() {
   $course = Course::factory()->create();

   get(route('course-details', $course))
       ->assertNotFound();
});

it('shows course details', function () {
    $course = Course::factory()->released()->create();

    get(route('course-details', $course))
        ->assertSeeText([
            $course->title,
            $course->description,
            $course->tagline,
            ...$course->learnings
        ])
        ->assertSee(assert("images/$course->image_name"));
});

it('shows course video count', function () {
    $course = Course::factory()
        ->released()
        ->has(Video::factory()->count(3))
        ->create();

    get(route('course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');
});
