<?php

namespace BinaryCats\FireableAttributeEvents\Tests\stubs;

use Illuminate\Database\Eloquent\Model;
use BinaryCats\FireableAttributeEvents\FireableAttributes;

class TestModel extends Model
{
    use FireableAttributes;

    /** @var array  */
    protected $guarded = [];

    /** @var array  */
    protected array $fireableAttributes = [
        'value' => ValueChanged::class,
        'status' => [
            'open' => StatusChangedToOpen::class,
        ],
    ];
}
