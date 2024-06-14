<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('returns a successful response', function () {
    // Act & Assert
    get(route('home'))
        ->assertOk();
});
