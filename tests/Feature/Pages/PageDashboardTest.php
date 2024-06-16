<?php

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use function Pest\Laravel\get;

it('cannot be accessed by a guest', function () {
    get(route('pages.dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchased courses', function () {
    $user = User::factory()
        ->has(Course::factory()->count(2)->state(
            new Sequence(
                ['title' => 'Course A'],
                ['title' => 'Course B']
            )
        ))
        ->create();

    loginAsUser($user);

    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText([
            'Course A',
            'Course B',
        ]);
});

it('does not list any other courses', function () {
    $course = Course::factory()->create();

    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSeeText($course->title);
});

it ('shows latest purchased course first', function () {
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->courses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]);
    $user->courses()->attach($lastPurchasedCourse, ['created_at' => Carbon::now()]);

    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeTextInOrder([
            $lastPurchasedCourse->title,
            $firstPurchasedCourse->title
        ]);
});

it ('includes link to product videos', function () {
    $user = User::factory()
        ->has(Course::factory())
        ->create();

    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch Videos')
        ->assertSee(route('pages.course-videos', Course::first()));
});

it('includes logout if logged in', function () {
    loginAsUser();
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});

it('does not find JetStream registration page', function () {
    get('register')
        ->assertNotFound();
});

it('includes logout', function () {
    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});


