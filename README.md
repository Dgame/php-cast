# Type Assumptions & Assertions simplified

Have you ever had to validate user data? Probably you have used something like [webmozarts/assert](https://github.com/webmozarts/assert):

```php
$id = $data['id'] ?? null;
Assert::integer($id);
```

The problem is, even though we checked that `$id` must be an `int`, it is actually still seen as `mixed` (see [this example](https://phpstan.org/r/dca4ad02-603d-4fdc-814b-1cdfcfe508e7) for phpstan).
To change this, you need to write / use your own phpstan rule that makes phpstan believe that it will now always be an `int`.
So if you use your own verification methods, you must also write / use your own phpstan rules.

This package tries to simplify that. To verify that something is an `int`, you can _assume_ that it must be an `int`. If it is not, you get `null`:

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

Now `$id` is of type `int` or it fails with an `AssertionError`. A message for the `AssertionError` can also be optionally set:

```php
use function Dgame\Cast\Assert\int;

$id = int($data['id'] ?? null, message: 'The id of the given user must be of type int');
```

You can do that for [int](#int), [float](#float), [bool](#bool), [string](#string), [number](#number), [scalar](#scalar) and [array](#array) values.

----

# int

### intify

With `intify` you get either the `int`-value or the `int`-casted `scalar` value, if any:

```php
use function Dgame\Cast\Assume\intify;

$id = intify($data['id'] ?? null); // $id is of type int|null
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

$money = float($data['money'] ?? null); // $money is of type float|null
```

# bool

With `bool` you get the bool-value for `true`, `false`, `1`, `0`, `on`, `off`, `yes`, `no` or null.

```php
use function Dgame\Cast\Assume\bool;

$checked = bool($data['checked'] ?? null); // $checked is of type bool|null
```

### boolify

With `boolify` you get either the `bool`-value or the `bool`-casted `scalar` value, if any:

```php
use function Dgame\Cast\Assume\boolify;

$checked = boolify($data['checked'] ?? null); // $checked is of type bool|null
```

# string

### stringify

With `stringify` you get either the `string`-value or the `string`-casted `scalar` value, if any:

```php
use function Dgame\Cast\Assume\stringify;

$value = stringify($data['value'] ?? null); // $value is of type string|null
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

With `collection` you can test whether your value is an `array`:

```php
use function Dgame\Cast\Assume\collection;

$values = collection($data['values'] ?? null); // $values is of type array<int|string, mixed>|null
```

And with `collectionOf` you can test whether your value is an `array` of type `T`:

```php
use function Dgame\Cast\Assume\collectionOf;

$values = collectionOf('Dgame\Cast\Assume\int', $data['values'] ?? null); // $values is of type array<int|string, int>|null
```

If **not** all values in the `array` are of type `int`, you get `null`. If you just want to filter the non-`int` values, you can do that by using `filter`:

```php
use function Dgame\Cast\Collection\filter;

$values = filter('Dgame\Cast\Assume\int', $data['values'] ?? []); // $values is of type array<int|string, int>
```

But be aware that `filter` expects an `array<int|string, mixed>` as input and not `mixed`!

### list

If you want to make sure, that you have a `list` of values (and not an assoc. array) you can use `listOf`:

```php
use function Dgame\Cast\Assume\listOf;

$values = listOf('Dgame\Cast\Assume\int', $data['values'] ?? null); // $values is of type int[]|null or, to be more accurate, of type array<int, int>|null
```

### map

If you want to make sure, that you have an assoc. array (and not a `list`) you can use `mapOf`:

```php
use function Dgame\Cast\Assume\mapOf;

$values = mapOf('Dgame\Cast\Assume\int', $data['values'] ?? null); // $values is of type array<string, int>|null
```
