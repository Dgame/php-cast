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
