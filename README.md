# Fireable Attribute Events

Observe and trigger events based on attributes changes

---

## Installation

You can install the package via Composer:

```bash
composer require binarycats/fireable-attribute-events
```

## Usage

Add the `FireableAttributes` Trait to Your Model:

In any Eloquent model where you want to fire events on attribute changes, 
use the `FireableAttributes` trait and define a `fireableAttributes` array:


```php
use App\Events\OrderStatusChanged;
use App\Events\OrderMarkedHighPriority;
use App\Events\OrderMarkedUrgent;
use BinaryCats\FireableAttributeEvents\FireableAttributes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use FireableAttributes;

    protected array $fireableAttributes = [
        'status' => OrderStatusChanged::class,
        'priority' => [
            'high' => OrderMarkedHighPriority::class,
            'urgent' => \OrderMarkedUrgent::class,
        ],
    ];
}
```

- **Direct mapping**: If status changes, it fires OrderStatusChanged.
- **Value-based mapping**: If priority changes to 'high', it fires OrderMarkedHighPriority; if 'urgent', it fires OrderMarkedUrgent.

Each event should accept the model as a constructor parameter.

Events Fire Automatically When Attributes Change.
Once a model using `FireableAttributes` is updated, the package will automatically dispatch the corresponding event:

```php
$order = Order::find(1);

$order->update(['status' => 'shipped']); // 🚀 Fires OrderStatusChanged event
$order->update(['priority' => 'urgent']); // 🚀 Fires OrderMarkedUrgent event
```

## Testing

```bash
vendor/bin/pest
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email cyrill.kalita@gmail.com instead of using issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

## Credits

- [Cyrill Kalita](https://github.com/binary-cats)
- [All Contributors](../../contributors)

## Support us

Binary Cats is a webdesign agency based in Illinois, US.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
