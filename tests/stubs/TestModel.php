<?php

namespace BinaryCats\FireableAttributeEvents\Tests\stubs;

use BinaryCats\FireableAttributeEvents\FireableAttributes;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use FireableAttributes;

    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected array $fireableAttributes = [
        'value'  => ValueChanged::class,
        'status' => [
            'open' => StatusChangedToOpen::class,
        ],
    ];
}
