<?php

declare(strict_types=1);

namespace Dgame\Cast\Assert;

use AssertionError;

function int(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Assume\int($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be int');
}

function intify(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Assume\intify($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be int');
}

function float(mixed $value, ?string $message = null): float
{
    $result = \Dgame\Cast\Assume\float($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be float');
}

function floatify(mixed $value, ?string $message = null): float
{
    $result = \Dgame\Cast\Assume\floatify($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be float');
}

function bool(mixed $value, ?string $message = null): bool
{
    $result = \Dgame\Cast\Assume\bool($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be bool');
}

function boolify(mixed $value, ?string $message = null): bool
{
    $result = \Dgame\Cast\Assume\boolify($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be bool');
}

function string(mixed $value, ?string $message = null): string
{
    $result = \Dgame\Cast\Assume\string($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be string');
}

function stringify(mixed $value, ?string $message = null): string
{
    $result = \Dgame\Cast\Assume\stringify($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be string');
}

function number(mixed $value, ?string $message = null): float|int
{
    $result = \Dgame\Cast\Assume\number($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be float|int');
}

function scalar(mixed $value, ?string $message = null): float|int|bool|string
{
    $result = \Dgame\Cast\Assume\scalar($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be float|int|bool|string');
}

/**
 * @phpstan-return int<0, max>
 */
function unsigned(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Assume\unsigned($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be >= 0');
}

/**
 * @phpstan-return int<1, max>
 */
function positive(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Assume\positive($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be > 0');
}

/**
 * @phpstan-return int<min, -1>
 */
function negative(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Assume\negative($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be < 0');
}

/**
 * @return array<int|string, mixed>
 */
function collection(mixed $value, ?string $message = null): array
{
    $result = \Dgame\Cast\Assume\collection($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be an assoc. array');
}

/**
 * @template T
 *
 * @param callable(mixed): T $typeEnsurance
 * @param mixed              $values
 * @param string|null        $message
 *
 * @return array<int|string, T>
 */
function collectionOf(callable $typeEnsurance, mixed $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Assume\collectionOf($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be an assoc. array');
}

/**
 * @template T
 *
 * @param callable(mixed): T $typeEnsurance
 * @param mixed              $values
 * @param string|null        $message
 *
 * @return non-empty-array<int|string, T>
 */
function collectionOfNonEmpty(callable $typeEnsurance, mixed $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Assume\collectionOfNonEmpty($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be a non-empty assoc. array');
}

/**
 * @template T
 *
 * @param callable(mixed): T $typeEnsurance
 * @param mixed              $values
 * @param string|null        $message
 *
 * @return array<string, T>
 */
function mapOf(callable $typeEnsurance, mixed $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Assume\mapOf($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be an assoc. array');
}

/**
 * @template T
 *
 * @param callable(mixed): T $typeEnsurance
 * @param mixed              $values
 * @param string|null        $message
 *
 * @return non-empty-array<string, T>
 */
function mapOfNonEmpty(callable $typeEnsurance, mixed $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Assume\mapOfNonEmpty($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be a non-empty assoc. array');
}

/**
 * @template T
 *
 * @param callable(mixed): T $typeEnsurance
 * @param mixed              $values
 * @param string|null        $message
 *
 * @return array<int, T>
 */
function listOf(callable $typeEnsurance, mixed $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Assume\listOf($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be a list');
}

/**
 * @template T
 *
 * @param callable(mixed): T $typeEnsurance
 * @param mixed              $values
 * @param string|null        $message
 *
 * @return non-empty-array<int, T>
 */
function listOfNonEmpty(callable $typeEnsurance, mixed $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Assume\listOfNonEmpty($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be a non-empty list');
}

/**
 * @return int[]
 */
function ints(int ...$values): array
{
    return array_values($values);
}

/**
 * @return float[]
 */
function floats(float ...$values): array
{
    return array_values($values);
}

/**
 * @return bool[]
 */
function bools(bool ...$values): array
{
    return array_values($values);
}

/**
 * @return string[]
 */
function strings(string ...$values): array
{
    return array_values($values);
}
