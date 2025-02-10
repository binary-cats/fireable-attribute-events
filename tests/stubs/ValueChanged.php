<?php

namespace BinaryCats\FireableAttributeEvents\Tests\stubs;

class ValueChanged
{
    public function __construct(
        public readonly TestModel $model,
    ) {
    }
}
