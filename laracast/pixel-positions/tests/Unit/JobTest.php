<?php

use App\Models\Employer;
use App\Models\Job;

it('Belongs to an employer', function () {
    // Arrange
    $employer = Employer::factory()->create();
    $job = Job::factory()->create([
        'employer_id' => $employer->id
    ]);

    // Act and assert
    expect($job->employer->is($employer))->toBeTrue();
});

it("Can have tags", function() {
    $job = Job::factory()->create();

    $job->tag('Frontend');

    expect($job->tags)->toHaveCount(1);
});