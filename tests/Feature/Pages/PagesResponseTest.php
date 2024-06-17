<?php

use App\Models\Course;
use App\Models\Video;

use function Pest\Laravel\get;

it('returns a successful response for the home page', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk();
});

it('returns a successful response for course details page', function () {
    $course = Course::factory()->released()->create();
    get(route('pages.course-details', $course))
        ->assertOk();
});

it('returns a successful response for dashboard page', function () {
    loginAsUser();

    $course = Course::factory()->released()->create();
    get(route('pages.dashboard'))
        ->assertOk();
});

it('gives successful response for videos page', function () {
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    loginAsUser();
    get(route('pages.course-videos', $course))
        ->assertOk();
});
