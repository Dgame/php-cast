<?php

declare(strict_types=1);

namespace Dgame\Cast\Must;

use AssertionError;

function int(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Should\int($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be int');
}

function intify(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Should\intify($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be int');
}

function float(mixed $value, ?string $message = null): float
{
    $result = \Dgame\Cast\Should\float($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be float');
}

function floatify(mixed $value, ?string $message = null): float
{
    $result = \Dgame\Cast\Should\floatify($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be float');
}

function bool(mixed $value, ?string $message = null): bool
{
    $result = \Dgame\Cast\Should\bool($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be bool');
}

function boolify(mixed $value, ?string $message = null): bool
{
    $result = \Dgame\Cast\Should\boolify($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be bool');
}

function string(mixed $value, ?string $message = null): string
{
    $result = \Dgame\Cast\Should\string($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be string');
}

function stringify(mixed $value, ?string $message = null): string
{
    $result = \Dgame\Cast\Should\stringify($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be string');
}

function number(mixed $value, ?string $message = null): float|int
{
    $result = \Dgame\Cast\Should\number($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be float|int');
}

function scalar(mixed $value, ?string $message = null): float|int|bool|string
{
    $result = \Dgame\Cast\Should\scalar($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be float|int|bool|string');
}

/**
 * @phpstan-return int<0, max>
 */
function unsigned(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Should\unsigned($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be >= 0');
}

/**
 * @phpstan-return int<min, 0>
 */
function signed(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Should\signed($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be <= 0');
}

/**
 * @phpstan-return int<1, max>
 */
function positive(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Should\positive($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be > 0');
}

/**
 * @phpstan-return int<min, -1>
 */
function negative(mixed $value, ?string $message = null): int
{
    $result = \Dgame\Cast\Should\negative($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be < 0');
}

/**
 * @return array<int|string, mixed>
 */
function assoc(mixed $value, ?string $message = null): array
{
    $result = \Dgame\Cast\Should\assoc($value);

    return $result ?? throw new AssertionError($message ?? var_export($value, true) . ' must be an assoc. array');
}

/**
 * @template T
 *
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return array<int|string, T>
 */
function assocOf(callable $typeEnsurance, array $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Should\assocOf($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be an assoc. array');
}

/**
 * @template T
 *
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return non-empty-array<int|string, T>
 */
function assocOfNonEmpty(callable $typeEnsurance, array $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Should\assocOfNonEmpty($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be a non-empty assoc. array');
}

/**
 * @template T
 *
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return array<int, T>
 */
function listOf(callable $typeEnsurance, array $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Should\listOf($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be a list');
}

/**
 * @template T
 *
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return non-empty-array<int, T>
 */
function listOfNonEmpty(callable $typeEnsurance, array $values, ?string $message = null): array
{
    $result = \Dgame\Cast\Should\listOfNonEmpty($typeEnsurance, $values);

    return $result ?? throw new AssertionError($message ?? var_export($values, true) . ' must be a non-empty list');
}
