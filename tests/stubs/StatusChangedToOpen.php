<?php

namespace BinaryCats\FireableAttributeEvents\Tests\stubs;

class StatusChangedToOpen
{
    public function __construct(
        public readonly TestModel $model,
    ) {
    }
}
