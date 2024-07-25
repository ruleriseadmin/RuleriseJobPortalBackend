<?php
use App\Models\Domain\Shared\SubscriptionPlan;

test('That admin can create new plan', function(){
    $response = $this->post('/v1/admin/plan', [
        'name' => 'Lite Plan',
        'price' => 100,
        'interval' => 'day',
        'duration' => '15',
        'numberOfCandidate' => '50',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(SubscriptionPlan::count())->toBe(1);

    expect(SubscriptionPlan::first()->name)->toBe('Lite Plan');

    //dd(SubscriptionPlan::first());

   //plan_QXK1LrrN4UErAQ //prod_QXK1yDjxYqLKsF
});

//test('That admin can update plan', function(){);
