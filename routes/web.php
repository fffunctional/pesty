<?php

use App\Http\Controllers\PageCourseDetailsController;
use App\Http\Controllers\PageHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', PageHomeController::class)->name('home');

Route::get('courses/{course:slug}', PageCourseDetailsController::class)
    ->name('course-details');
