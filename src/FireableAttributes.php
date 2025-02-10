<?php

namespace BinaryCats\FireableAttributeEvents;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait FireableAttributes
{
    /**
     * Process attributes on model update.
     *
     * @return void
     */
    protected static function bootFireableAttributes(): void
    {
        static::updated(fn ($model) => Fireable::make($model)->processAttributes());
    }

    /**
     * Get a list of model's "fireable" attributes.
     *
     * @return array
     */
    public function getFireableAttributes(): array
    {
        return $this->fireableAttributes ?? [];
    }
}
