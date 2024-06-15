<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows course details', function () {
    $course = Course::factory()->create([
       'tagline' => 'Course tagline',
       'image' => 'image.png',
       'learnings' => [
           'Learn Laravel routes',
           'Learn Laravel views',
           'Learn Laravel commands',
       ]
    ]);

    get(route('course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            'Course tagline',
            'Learn Laravel routes',
            'Learn Laravel views',
            'Learn Laravel commands',
        ])
        ->assertSee('image.png');
});

it('shows course video count', function () {
    
});
