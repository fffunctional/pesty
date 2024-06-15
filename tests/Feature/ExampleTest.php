<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('returns a successful response for the home page', function () {
    // Act & Assert
    get(route('home'))
        ->assertOk();
});

it('returns a successful response for course details page', function () {
   $course = Course::factory()->create();
   get(route('course-details', $course))
        ->assertOk();
});

