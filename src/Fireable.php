<?php

namespace BinaryCats\FireableAttributeEvents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Fireable
{
    public function __construct(
        protected readonly Model $model,
        protected readonly array $fireableAttributes = [],
    ) {
    }

    /**
     * @param \BinaryCats\FireableAttributeEvents\FireableAttributes|Model $model
     * @return $this
     */
    public static function make($model): static
    {
        return new static($model, $model->getFireableAttributes());
    }

    /**
     * Match updated attributes with fireable ones and trigger events.
     *
     * @param \BinaryCats\FireableAttributeEvents\FireableAttributes|Model $model
     * @return void
     */
    public function processAttributes(): void
    {
        $this->updatedAttributes()->each(function ($value, $attribute) {
            if ($eventName = $this->getEventName($attribute, $value)) {
                event(new $eventName($this->model));
            }
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function updatedAttributes(): Collection
    {
        return collect($this->model->getDirty())
            ->intersectByKeys($this->fireableAttributes);
    }

    /**
     * Get event name for specified attribute and assigned value pair.
     *
     * @param string $attribute
     * @param mixed $value
     * @return string|null
     */
    private function getEventName(string $attribute, mixed $value): ?string
    {
        return $this->getEventNameForAttribute($attribute)
            ?? $this->getEventNameForExactValue($attribute, $value);
    }

    /**
     * Get event name if values are not specified.
     *
     * @param string $attribute
     * @return string|null
     */
    private function getEventNameForAttribute(string $attribute): ?string
    {
        return array_key_exists($attribute, $this->fireableAttributes)
        && is_string($this->fireableAttributes[$attribute])
        && class_exists($this->fireableAttributes[$attribute])
            ? $this->fireableAttributes[$attribute]
            : null;
    }

    /**
     * Get event name if there are specified values.
     *
     * @param string $attribute
     * @param mixed $value
     * @return string|null
     */
    private function getEventNameForExactValue(string $attribute, mixed $value): ?string
    {
        return array_key_exists($attribute, $this->fireableAttributes)
        && is_array($this->fireableAttributes[$attribute])
        && isset($this->fireableAttributes[$attribute][$value])
            ? $this->fireableAttributes[$attribute][$value]
            : null;
    }
}
