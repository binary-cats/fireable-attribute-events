<?php

use BinaryCats\FireableAttributeEvents\Fireable;
use BinaryCats\FireableAttributeEvents\Tests\stubs\StatusChangedToOpen;
use BinaryCats\FireableAttributeEvents\Tests\stubs\TestModel;
use BinaryCats\FireableAttributeEvents\Tests\stubs\ValueChanged;
use Illuminate\Support\Facades\Event;

beforeEach(fn () => Event::fake([
    StatusChangedToOpen::class,
    ValueChanged::class,
])); // Prevent actual event dispatching

it('fires events for updated attributes', function () {
    // Create a model instance
    $model = TestModel::create(['value' => 'one']);

    // Change an attribute that should trigger an event
    $model->update(['value' => 'two']);

    // Assert that the correct event was dispatched with the expected model value
    Event::assertDispatched(ValueChanged::class, fn ($event) => $event->model->value === 'two');
});

it('fires events for updated values', function () {
    $model = TestModel::create(['status' => 'pending']);

    // Change an attribute that is fireable
    $model->update(['status' => 'open']);

    // Assert that the correct event was dispatched with the expected model value
    Event::assertDispatched(StatusChangedToOpen::class, fn ($event) => $event->model->status === 'open');
});

it('does not fire events for missing values', function () {
    $model = TestModel::create(['status' => 'pending']);

    // Change an attribute value that is not mapped to an event
    $model->update(['status' => 'closed']);

    // Ensure that no events are dispatched
    Event::assertNothingDispatched();
});

it('does not fire events for non-fireable attributes', function () {
    $model = TestModel::create(['status' => 'pending', 'value' => 'one', 'random' => 'whatever']);

    // Change an attribute that is *not* fireable
    $model->update(['random' => 'Trump is a traitor']);

    // Ensure that no events are dispatched
    Event::assertNothingDispatched();
});

it('can create Fireable statically', function () {
    $model = TestModel::create(['status' => 'pending']);

    $fireable = Fireable::make($model);

    expect($fireable)->toBeInstanceOf(Fireable::class);
});
