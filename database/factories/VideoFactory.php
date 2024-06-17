<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'slug' => $this->faker->sentence,
            'vimeo_id' => $this->faker->uuid,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'duration_in_min' => $this->faker->numberBetween(1, 99),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
