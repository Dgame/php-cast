# Type Assumptions & Assertions simplified

Every had to validate User data? You probably used something like [Webmozart/Assert]() like

```php
$id = $data['id'] ?? null;
Assert::isInt($id);
```

The problem is, although we verified that `$id` must be an `int`, in truth it is still seen as `mixed` for e.g. phpstan.
That is if you don't have written your own phpstan rule which makes phpstan believe that now it will always be an `int`.
So if you use your own verification methods, you have to write your own phpstan rules too!

This package tries to simplify that. To verify that something is an int you can _assume_ that it must be an `int`. If it isn't you get `null`:

```php
use function Dgame\Cast\Assume\int;

$id = int($data['id'] ?? null);
```

With this, `$id` is of type `int|null` for phpstan, psalm, phpstorm and so on.

If you want to _assert_ that it is an `int`, you can do that too by using:

```php
use function Dgame\Cast\Assert\int;

$id = int($data['id'] ?? null);
```

Now `$id` is of type `int` or it fails with an `AssertionError`. A message for the `AssertionError` can be optional set too:

```php
use function Dgame\Cast\Assert\int;

$id = int($data['id'] ?? null, message: 'The id of the given user must be of type int');
```

You can do the that for [int](#int), [float](#float), [bool](#bool), [string](#string), [number](#number), [scalar](#scalar) and [array](#array) values.

----

# int

### intify

With `intify` you get either the `int`-value or the `int`-casted `scalar` value, if any:

```php
use function Dgame\Cast\Assume\intify;

$id = intify($data['id'] ?? null);
```

### unsigned

`unsigned` will return a non-null value, if the given value is a [number](#number) that is >= 0.

```php
use function Dgame\Cast\Assume\unsigned;

$id = unsigned($data['id'] ?? null); // $id is of type int|null and >= 0 if it is an int
```

### positive

`positive` will return a non-null value, if the given value is a [number](#number) that is > 0.

```php
use function Dgame\Cast\Assume\positive;

$id = positive($data['id'] ?? null); // $id is of type int|null and > 0 if it is an int
```

### negative

`negative` will return a non-null value, if the given value is a [number](#number) that is < 0.

```php
use function Dgame\Cast\Assume\negative;

$id = negative($data['id'] ?? null); // $id is of type int|null and < 0 if it is an int
```

# float

### floatify

With `floatify` you get either the `float`-value or the `float`-casted `scalar` value, if any:

```php
use function Dgame\Cast\Assume\float;

$money = float($data['money'] ?? null);
```

# bool

With `bool` you get the bool-value for `true`, `false`, `1`, `0`, `on`, `off`, `yes`, `no` or null.

```php
use function Dgame\Cast\Assume\bool;

$checked = bool($data['checked'] ?? null);
```

### boolify

With `boolify` you get either the `bool`-value or the `bool`-casted `scalar` value, if any:

```php
use function Dgame\Cast\Assume\boolify;

$checked = boolify($data['checked'] ?? null);
```

# string

### stringify

With `stringify` you get either the `string`-value or the `string`-casted `scalar` value, if any:

```php
use function Dgame\Cast\Assume\stringify;

$value = stringify($data['value'] ?? null);
```

# number

With `number` you get either the `int` or `float`-value or null, if it is neither.

```php
use function Dgame\Cast\Assume\number;

$range = number($data['range'] ?? null); // $range is of type int|float|null
```

# scalar

With `scalar` you get either the `int`, `float`, `bool` or `string`-value or null, if it is neither.

```php
use function Dgame\Cast\Assume\scalar;

$value = scalar($data['value'] ?? null); // $value is of type int|float|bool|string|null
```

# array

### list

### map

### filter
