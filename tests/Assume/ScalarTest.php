<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Assume;

use function Dgame\Cast\Assume\scalar;
use PHPUnit\Framework\TestCase;

final class ScalarTest extends TestCase
{
    /**
     * @param mixed      $input
     * @param int|float|bool|string|null $expected
     *
     * @dataProvider provideScalars
     */
    public function testScalar(mixed $input, int|float|bool|string|null $expected): void
    {
        $this->assertSame($expected, scalar($input));
    }

    public function provideScalars(): iterable
    {
        yield [42, 42];
        yield [4.2, 4.2];
        yield ['4.2', '4.2'];
        yield ['42', '42'];
        yield ['  42', '  42'];
        yield ['42  ', '42  '];
        yield ['  42  ', '  42  '];
        yield ['  4.2', '  4.2'];
        yield ['4.2  ', '4.2  '];
        yield ['  4.2  ', '  4.2  '];
        yield ['42a', '42a'];
        yield ['a42', 'a42'];
        yield ['4.2a', '4.2a'];
        yield ['a4.2', 'a4.2'];
        yield [true, true];
        yield [false, false];
        yield ['true', 'true'];
        yield ['false', 'false'];
        yield ['yes', 'yes'];
        yield ['no', 'no'];
        yield ['on', 'on'];
        yield ['off', 'off'];
        yield ['abc', 'abc'];
        yield [null, null];
        yield ['1', '1'];
        yield ['0', '0'];
        yield [1, 1];
        yield [0, 0];
        yield [-1, -1];
        yield ['-1', '-1'];
        yield ['  -1', '  -1'];
        yield ['  - 1', '  - 1'];
        yield ['- 1', '- 1'];
        yield [[], null];
    }
}
