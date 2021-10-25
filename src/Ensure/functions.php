<?php

declare(strict_types=1);

namespace Dgame\Cast\Ensure;

function int(mixed $value, int $default): int
{
    return \Dgame\Cast\Assume\int($value) ?? $default;
}

function intify(mixed $value, int $default): int
{
    return \Dgame\Cast\Assume\intify($value) ?? $default;
}

function float(mixed $value, float $default): float
{
    return \Dgame\Cast\Assume\float($value) ?? $default;
}

function floatify(mixed $value, float $default): float
{
    return \Dgame\Cast\Assume\floatify($value) ?? $default;
}

function bool(mixed $value, bool $default): bool
{
    return \Dgame\Cast\Assume\bool($value) ?? $default;
}

function boolify(mixed $value, bool $default): bool
{
    return \Dgame\Cast\Assume\boolify($value) ?? $default;
}

function string(mixed $value, string $default): string
{
    return \Dgame\Cast\Assume\string($value) ?? $default;
}

function stringify(mixed $value, string $default): string
{
    return \Dgame\Cast\Assume\stringify($value) ?? $default;
}

function number(mixed $value, float|int $default): float|int
{
    return \Dgame\Cast\Assume\number($value) ?? $default;
}

function scalar(mixed $value, float|int|bool|string $default): float|int|bool|string
{
    return \Dgame\Cast\Assume\scalar($value) ?? $default;
}

/**
 * @param mixed                    $value
 * @param array<int|string, mixed> $default
 *
 * @return array<int|string, mixed>
 */
function collection(mixed $value, array $default): array
{
    return \Dgame\Cast\Assume\collection($value) ?? $default;
}

/**
 * @param iterable<int|string, mixed> $values
 * @param int[]                       $default
 *
 * @return int[]
 */
function ints(iterable $values, array $default = []): array
{
    return \Dgame\Cast\Assume\ints($values) ?? $default;
}

/**
 * @param iterable<int|string, mixed> $values
 * @param float[]                     $default
 *
 * @return float[]
 */
function floats(iterable $values, array $default = []): array
{
    return \Dgame\Cast\Assume\floats($values) ?? $default;
}

/**
 * @param iterable<int|string, mixed> $values
 * @param bool[]                      $default
 *
 * @return bool[]
 */
function bools(iterable $values, array $default = []): array
{
    return \Dgame\Cast\Assume\bools($values) ?? $default;
}

/**
 * @param iterable<int|string, mixed> $values
 * @param string[]                    $default
 *
 * @return string[]
 */
function strings(iterable $values, array $default = []): array
{
    return \Dgame\Cast\Assume\strings($values) ?? $default;
}

/**
 * @param iterable<int|string, mixed>       $values
 * @param array<int, float|int|bool|string> $default
 *
 * @return array<int, float|int|bool|string>
 */
function scalars(iterable $values, array $default = []): array
{
    return \Dgame\Cast\Assume\scalars($values) ?? $default;
}

/**
 * @param iterable<int|string, mixed> $values
 * @param array<int, int|float>       $default
 *
 * @return array<int, int|float>
 */
function numbers(iterable $values, array $default = []): array
{
    return \Dgame\Cast\Assume\numbers($values) ?? $default;
}
