<?php

declare(strict_types=1);

namespace Dgame\Cast\Collection;

use function Dgame\Cast\Assume\collectionOf;

/**
 * @template T
 *
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 *
 * @return array<int|string, T>
 */
function filter(callable $typeEnsurance, array $values): array
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
 * @param callable(mixed): T       $typeEnsurance
 * @param array<int|string, mixed> $values
 * @param callable(T): T           $callback
 *
 * @return array<int|string, T>
 */
function filterMap(callable $typeEnsurance, array $values, callable $callback): array
{
    return collectionOf($typeEnsurance, array_map($callback, filter($typeEnsurance, $values))) ?? [];
}

/**
 * @param array<int|string, mixed> $values
 * @param callable(mixed): bool    $predicate
 *
 * @return bool
 */
function all(array $values, callable $predicate): bool
{
    foreach ($values as $value) {
        if (!$predicate($value)) {
            return false;
        }
    }

    return true;
}

/**
 * @param array<int|string, mixed> $values
 * @param callable(mixed): bool    $predicate
 *
 * @return bool
 */
function any(array $values, callable $predicate): bool
{
    foreach ($values as $value) {
        if ($predicate($value)) {
            return true;
        }
    }

    return false;
}
