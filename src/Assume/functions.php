<?php

declare(strict_types=1);

namespace Dgame\Cast\Assume;

use Closure;
use function Dgame\Cast\Collection\all;
use function Dgame\Cast\Collection\any;
use Stringable;
use Throwable;

function int(mixed $value): ?int
{
    return is_int($value) ? $value : filter_var($value, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
}

function intify(mixed $value): ?int
{
    $result = int($value);
    if ($result !== null) {
        return $result;
    }

    $result = scalar($value);

    return $result === null ? null : (int) $result;
}

function float(mixed $value): ?float
{
    return is_float($value) ? $value : filter_var($value, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
}

function floatify(mixed $value): ?float
{
    $result = float($value);
    if ($result !== null) {
        return $result;
    }

    $result = scalar($value);

    return $result === null ? null : (float) $result;
}

function bool(mixed $value): ?bool
{
    if ($value === null) {
        return null;
    }

    return is_bool($value) ? $value : filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
}

function boolify(mixed $value): ?bool
{
    $result = bool($value);
    if ($result !== null) {
        return $result;
    }

    $result = scalar($value);

    return $result === null ? null : (bool) $result;
}

function string(mixed $value): ?string
{
    return is_string($value) ? $value : null;
}

function stringify(mixed $value): ?string
{
    $result = string($value);
    if ($result !== null) {
        return $result;
    }

    $result = scalar($value);
    if ($result !== null) {
        return (string) $result;
    }

    return $value instanceof Stringable ? (string) $result : null;
}

function number(mixed $value): float|int|null
{
    return int($value) ?? float($value);
}

function scalar(mixed $value): float|int|bool|string|null
{
    if ($value === null) {
        return null;
    }

    if (is_string($value)) {
        return $value;
    }

    if (is_bool($value)) {
        return $value;
    }

    if (is_numeric($value)) {
        return number($value);
    }

    return null;
}

/**
 * @phpstan-return int<0, max>
 */
function unsigned(mixed $value): ?int
{
    $result = number($value);
    if ($result === null) {
        return null;
    }

    $result = (int) $result;

    return $result >= 0 ? $result : null;
}

/**
 * @phpstan-return int<1, max>
 */
function positive(mixed $value): ?int
{
    $result = number($value);
    if ($result === null) {
        return null;
    }

    $result = (int) $result;

    return $result > 0 ? $result : null;
}

/**
 * @phpstan-return int<min, -1>
 */
function negative(mixed $value): ?int
{
    $result = number($value);
    if ($result === null) {
        return null;
    }

    $result = (int) $result;

    return $result < 0 ? $result : null;
}

/**
 * @return array<int|string, mixed>|null
 */
function collection(mixed $value): ?array
{
    return is_array($value) ? $value : null;
}

/**
 * @template T
 *
 * @param callable(mixed): ?T $typeEnsurance
 * @param mixed               $values
 *
 * @return array<int|string, T>|null
 */
function collectionOf(callable $typeEnsurance, mixed $values): ?array
{
    $values = collection($values);
    if ($values === null) {
        return null;
    }

    $output = [];
    foreach ($values as $key => $value) {
        if ($value === null) {
            return null;
        }

        $result = $typeEnsurance($value);
        if ($result === null) {
            return null;
        }

        $output[$key] = $result;
    }

    return $output;
}

/**
 * @template T
 *
 * @param callable(mixed): ?T $typeEnsurance
 * @param mixed               $values
 *
 * @return non-empty-array<int|string, T>|null
 */
function collectionOfNonEmpty(callable $typeEnsurance, mixed $values): ?array
{
    $values = collectionOf($typeEnsurance, $values);

    return $values === null || $values === [] ? null : $values;
}

/**
 * @template T
 *
 * @param callable(mixed): ?T $typeEnsurance
 * @param mixed               $values
 *
 * @return array<string, T>|null
 */
function mapOf(callable $typeEnsurance, mixed $values): ?array
{
    $values = collectionOf($typeEnsurance, $values);
    if ($values === null) {
        return null;
    }

    if (!all(array_keys($values), 'is_string')) {
        return null;
    }

    /** @phpstan-ignore-next-line => phpstan does not recognize that we ensured string-keys through the if above */
    return $values;
}

/**
 * @template T
 *
 * @param callable(mixed): ?T $typeEnsurance
 * @param mixed               $values
 *
 * @return non-empty-array<string, T>|null
 */
function mapOfNonEmpty(callable $typeEnsurance, mixed $values): ?array
{
    $values = mapOf($typeEnsurance, $values);

    return $values === null || $values === [] ? null : $values;
}

/**
 * @template T
 *
 * @param callable(mixed): ?T $typeEnsurance
 * @param mixed               $values
 *
 * @return array<int, T>|null
 */
function listOf(callable $typeEnsurance, mixed $values): ?array
{
    $values = collectionOf($typeEnsurance, $values);
    if ($values === null) {
        return null;
    }

    return array_values($values);
}

/**
 * @template T
 *
 * @param callable(mixed): ?T $typeEnsurance
 * @param mixed               $values
 *
 * @return non-empty-array<int, T>|null
 */
function listOfNonEmpty(callable $typeEnsurance, mixed $values): ?array
{
    $values = listOf($typeEnsurance, $values);

    return $values === null || $values === [] ? null : $values;
}

/**
 * @param iterable<int|string, mixed> $values
 *
 * @return int[]|null
 */
function ints(iterable $values): ?array
{
    return listOf('\Dgame\Cast\Assume\int', $values);
}

/**
 * @param iterable<int|string, mixed> $values
 *
 * @return float[]|null
 */
function floats(iterable $values): ?array
{
    return listOf('\Dgame\Cast\Assume\float', $values);
}

/**
 * @param iterable<int|string, mixed> $values
 *
 * @return bool[]|null
 */
function bools(iterable $values): ?array
{
    return listOf('\Dgame\Cast\Assume\bool', $values);
}

/**
 * @param iterable<int|string, mixed> $values
 *
 * @return string[]|null
 */
function strings(iterable $values): ?array
{
    return listOf('\Dgame\Cast\Assume\string', $values);
}

/**
 * @param iterable<int|string, mixed> $values
 *
 * @return list<float|int|bool|string>|null
 */
function scalars(iterable $values): ?array
{
    return listOf('\Dgame\Cast\Assume\scalar', $values);
}

/**
 * @param iterable<int|string, mixed> $values
 *
 * @return list<int|float>|null
 */
function numbers(iterable $values): ?array
{
    return listOf('\Dgame\Cast\Assume\number', $values);
}

/**
 * @template T
 *
 * @param Closure():T                  $closure
 * @param null|Closure(Throwable):void $handler
 *
 * @return T|null
 */
function trying(Closure $closure, Closure $handler = null): mixed
{
    try {
        return $closure();
    } catch (Throwable $t) {
        if ($handler !== null) {
            $handler($t);
        }

        return null;
    }
}

/**
 * @template T
 *
 * @param Closure():T             $closure
 * @param class-string<Throwable> $exception
 * @param class-string<Throwable> ...$exceptions
 *
 * @return T|null
 * @throws Throwable
 */
function expect(Closure $closure, string $exception, string ...$exceptions): mixed
{
    try {
        return $closure();
    } catch (Throwable $t) {
        if (!in_array($t::class, [$exception, ...$exceptions], strict: true)) {
            throw $t;
        }

        return null;
    }
}

/**
 * @template T
 *
 * @param Closure():T             $closure
 * @param class-string<Throwable> $exception
 * @param class-string<Throwable> ...$exceptions
 *
 * @return T|null
 * @throws Throwable
 */
function expectInstanceOf(Closure $closure, string $exception, string ...$exceptions): mixed
{
    try {
        return $closure();
    } catch (Throwable $t) {
        if (any([$exception, ...$exceptions], static fn(string $e) => $t instanceof $e)) {
            return null;
        }

        throw $t;
    }
}

/**
 * @template T of object
 *
 * @param class-string<T> $class
 * @param mixed           $object
 *
 * @return T|null
 */
function object(string $class, mixed $object): ?object
{
    return $object instanceof $class ? $object : null;
}
