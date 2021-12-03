<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Ensure;

use function Dgame\Cast\Ensure\number;
use PHPUnit\Framework\TestCase;

final class NumberTest extends TestCase
{
    /**
     * @param mixed      $input
     * @param int|float $expected
     *
     * @dataProvider provideNumbers
     */
    public function testNumber(mixed $input, int|float $expected): void
    {
        $this->assertSame($expected, number($input, default: 0));
    }

    public function provideNumbers(): iterable
    {
        yield [42, 42];
        yield [4.2, 4.2];
        yield ['4.2', 4.2];
        yield ['42', 42];
        yield ['  42', 42];
        yield ['42  ', 42];
        yield ['  42  ', 42];
        yield ['  4.2', 4.2];
        yield ['4.2  ', 4.2];
        yield ['  4.2  ', 4.2];
        yield ['42a', 0];
        yield ['a42', 0];
        yield ['4.2a', 0];
        yield ['a4.2', 0];
        yield [true, 1];
        yield [false, 0];
        yield ['true', 0];
        yield ['false', 0];
        yield ['yes', 0];
        yield ['no', 0];
        yield ['on', 0];
        yield ['off', 0];
        yield ['abc', 0];
        yield [null, 0];
        yield ['1', 1];
        yield ['0', 0];
        yield [1, 1];
        yield [0, 0];
        yield [-1, -1];
        yield ['-1', -1];
        yield ['  -1', -1];
        yield ['  - 1', 0];
        yield ['- 1', 0];
        yield [[], 0];
    }
}
