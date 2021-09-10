<?php

declare(strict_types=1);

namespace Dgame\Cast\Should;

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

    return $value instanceof \Stringable ? (string) $result : null;
}

function number(mixed $value): float|int|null
{
    return int($value) ?? float($value);
}

function scalar(mixed $value): float|int|bool|string|null
{
    return number($value) ?? bool($value) ?? string($value);
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
 * @phpstan-return int<min, 0>
 */
function signed(mixed $value): ?int
{
    $result = number($value);
    if ($result === null) {
        return null;
    }

    $result = (int) $result;

    return $result <= 0 ? $result : null;
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
function assoc(mixed $value): ?array
{
    return is_array($value) ? $value : null;
}

/**
 * @template T
 *
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return array<int|string, T>|null
 */
function assocOf(callable $typeEnsurance, array $values): ?array
{
    $output = [];
    foreach ($values as $key => &$value) {
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
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return non-empty-array<int|string, T>|null
 */
function assocOfNonEmpty(callable $typeEnsurance, array $values): ?array
{
    $values = assocOf($typeEnsurance, $values);

    return $values === null || $values === [] ? null : $values;
}

/**
 * @template T
 *
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return array<int, T>|null
 */
function listOf(callable $typeEnsurance, array $values): ?array
{
    $values = assocOf($typeEnsurance, $values);
    if ($values === null || !array_is_list($values)) {
        return null;
    }

    /** @phpstan-ignore-next-line */
    return $values;
}

/**
 * @template T
 *
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return non-empty-array<int, T>|null
 */
function listOfNonEmpty(callable $typeEnsurance, array $values): ?array
{
    $values = listOf($typeEnsurance, $values);

    return $values === null || $values === [] ? null : $values;
}

if (version_compare(PHP_VERSION, '8.1') === 1) {
    /**
     * @template T
     *
     * @param array<int|string, T> $array
     *
     * @return bool
     */
    function array_is_list(array $array): bool
    {
        if ($array === []) {
            return \true;
        }

        $nextKey = -1;
        foreach ($array as $k => $v) {
            if ($k !== ++$nextKey) {
                return false;
            }
        }

        return true;
    }
}
