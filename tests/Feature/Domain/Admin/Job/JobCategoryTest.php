<?php

use Database\Seeders\RoleSeeder;
use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Shared\Job\JobCategories;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test("That admin fetches job category", function () {
    $adminUser = AdminUser::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => JobCategories::factory()->create());

    $response = $this->actingAs($adminUser)->get('v1/admin/job-category');

    expect($response->json()['status'])->toBe('200');
});

test("That admin creates job category", function () {

    $adminUser = AdminUser::factory()->create();

    $response = $this->actingAs($adminUser)->post('v1/admin/job-category', [
        'name' => 'Transportation Machinery',
        'subcategories' => ['Shipping', 'mechanical engineering'],
        'svgIcon' => '<svg>'
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(JobCategories::count())->toBe(1);

    expect(JobCategories::first()->name)->toBe('Transportation Machinery');

    expect(JobCategories::first()->svg_icon)->toBe('<svg>');

    expect(JobCategories::first()->subcategories)->toBe(['Shipping', 'mechanical engineering']);
});

test("That admin updates job category", function () {

    $adminUser = AdminUser::factory()->create();

    $category = JobCategories::factory()->create();

    $response = $this->actingAs($adminUser)->post('v1/admin/job-category/update', [
        'name' => 'Transportation Machinery',
        'subcategories' => ['Shipping', 'mechanical engineering'],
        'categoryId' => $category->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(JobCategories::count())->toBe(1);

    expect($category->refresh()->name)->toBe('Transportation Machinery');

    expect(JobCategories::first()->subcategories)->toBe(['Shipping', 'mechanical engineering']);
});

test("That admin deletes job category", function () {

    $adminUser = AdminUser::factory()->create();

    $category = JobCategories::factory()->create();

    $response = $this->actingAs($adminUser)->post("v1/admin/job-category/{$category->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(JobCategories::count())->toBe(0);

    expect(JobCategories::onlyTrashed()->count())->toBe(1);
});

test("That admin active - inactive job category", function () {

    $adminUser = AdminUser::factory()->create();

    $category = JobCategories::factory()->create();

    $response = $this->actingAs($adminUser)->post("v1/admin/job-category/{$category->uuid}/setActive");

    expect($response->json()['status'])->toBe('200');

    expect((bool) $category->refresh()->active)->toBe(false);

    //expect(JobCategories::count())->toBe(0);

    //expect(JobCategories::onlyTrashed()->count())->toBe(1);
});
