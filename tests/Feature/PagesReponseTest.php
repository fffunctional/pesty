<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

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
    $user = User::factory()->create();

    $this->actingAs($user);

    $course = Course::factory()->released()->create();
    get(route('dashboard'))
        ->assertOk();
});

