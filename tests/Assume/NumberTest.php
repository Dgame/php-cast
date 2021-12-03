<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Assume;

use function Dgame\Cast\Assume\number;
use PHPUnit\Framework\TestCase;

final class NumberTest extends TestCase
{
    /**
     * @param mixed      $input
     * @param int|float|null $expected
     *
     * @dataProvider provideNumbers
     */
    public function testNumber(mixed $input, int|float|null $expected): void
    {
        $this->assertSame($expected, number($input));
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
        yield ['42a', null];
        yield ['a42', null];
        yield ['4.2a', null];
        yield ['a4.2', null];
        yield [true, 1];
        yield [false, null];
        yield ['true', null];
        yield ['false', null];
        yield ['yes', null];
        yield ['no', null];
        yield ['on', null];
        yield ['off', null];
        yield ['abc', null];
        yield [null, null];
        yield ['1', 1];
        yield ['0', 0];
        yield [1, 1];
        yield [0, 0];
        yield [-1, -1];
        yield ['-1', -1];
        yield ['  -1', -1];
        yield ['  - 1', null];
        yield ['- 1', null];
        yield [[], null];
    }
}
