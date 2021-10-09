<?php

declare(strict_types=1);

namespace Dgame\Cast\Collection;

use function Dgame\Cast\Assume\collectionOf;

/**
 * @template T
 *
 * @param callable(mixed): ?T         $typeEnsurance
 * @param iterable<int|string, mixed> $values
 *
 * @return array<int|string, T>
 */
function filter(callable $typeEnsurance, iterable $values): array
{
    $output = [];
    foreach ($values as $key => $value) {
        if ($value === null) {
            continue;
        }

        $value = $typeEnsurance($value);
        if ($value === null) {
            continue;
        }

        $output[$key] = $value;
    }

    return $output;
}

/**
 * @template T
 *
 * @param callable(mixed): ?T         $typeEnsurance
 * @param iterable<int|string, mixed> $values
 * @param callable(T): T              $callback
 *
 * @return array<int|string, T>
 */
function filterMap(callable $typeEnsurance, iterable $values, callable $callback): array
{
    return collectionOf($typeEnsurance, array_map($callback, filter($typeEnsurance, $values))) ?? [];
}

/**
 * @param iterable<int|string, mixed> $values
 * @param callable(mixed): bool       $predicate
 *
 * @return bool
 */
function all(iterable $values, callable $predicate): bool
{
    foreach ($values as $value) {
        if (!$predicate($value)) {
            return false;
        }
    }

    return true;
}

/**
 * @param iterable<int|string, mixed> $values
 * @param callable(mixed): bool       $predicate
 *
 * @return bool
 */
function any(iterable $values, callable $predicate): bool
{
    foreach ($values as $value) {
        if ($predicate($value)) {
            return true;
        }
    }

    return false;
}

/**
 * @param iterable<int|string, mixed> $values
 * @param string                      $characters
 *
 * @return array<int|string, mixed>
 */
function trimResursive(iterable $values, string $characters = " \t\n\r\0\x0B"): array
{
    $output = [];
    foreach ($values as $key => $value) {
        if (is_string($value)) {
            $value = trim($value, $characters);
        } elseif (is_iterable($value)) {
            $value = trimResursive($value, $characters);
        }

        $output[is_string($key) ? trim($key, $characters) : $key] = $value;
    }

    return $output;
}
