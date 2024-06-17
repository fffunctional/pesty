<?php

it('gives back readable video duration', function () {
    $video = \App\Models\Video::factory()->create(['duration_in_min' => 10]);

    expect($video->getReadableDuration())->toEqual('10min');
});
