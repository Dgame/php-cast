<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Assume;

use PHPUnit\Framework\TestCase;
use function Dgame\Cast\Assume\float;
use function Dgame\Cast\Assume\floatify;

final class FloatTest extends TestCase
{
    /**
     * @param mixed      $input
     * @param float|null $expected
     *
     * @dataProvider provideFloats
     */
    public function testFloat(mixed $input, ?float $expected): void
    {
        $this->assertSame($expected, float($input));
    }

    /**
     * @param mixed      $input
     * @param float|null $expected
     *
     * @dataProvider provideFloatify
     */
    public function testFloatify(mixed $input, ?float $expected): void
    {
        $this->assertSame($expected, floatify($input));
    }

    public function provideFloats(): iterable
    {
        yield [42, 42.0];
        yield [4.2, 4.2];
        yield ['4.2', 4.2];
        yield ['42', 42.0];
        yield ['  42', 42.0];
        yield ['42  ', 42.0];
        yield ['  42  ', 42.0];
        yield ['  4.2', 4.2];
        yield ['4.2  ', 4.2];
        yield ['  4.2  ', 4.2];
        yield ['42a', null];
        yield ['a42', null];
        yield ['4.2a', null];
        yield ['a4.2', null];
        yield [true, 1.0];
        yield [false, null];
        yield ['true', null];
        yield ['false', null];
        yield ['yes', null];
        yield ['no', null];
        yield ['on', null];
        yield ['off', null];
        yield ['abc', null];
        yield [null, null];
        yield ['0', 0.0];
        yield [-1, -1.0];
        yield ['-1', -1.0];
        yield ['  -1', -1.0];
        yield ['  - 1', null];
        yield ['- 1', null];
        yield [[], null];
    }

    public function provideFloatify(): iterable
    {
        yield [42, 42.0];
        yield [4.2, 4.2];
        yield ['4.2', 4.2];
        yield ['42', 42.0];
        yield ['  42', 42.0];
        yield ['42  ', 42.0];
        yield ['  42  ', 42.0];
        yield ['  4.2', 4.2];
        yield ['4.2  ', 4.2];
        yield ['  4.2  ', 4.2];
        yield ['42a', 42.0];
        yield ['a42', 0.0];
        yield ['4.2a', 4.2];
        yield ['a4.2', 0.0];
        yield [true, 1.0];
        yield [false, 0.0];
        yield ['true', 0.0];
        yield ['false', 0.0];
        yield ['yes', 0.0];
        yield ['no', 0.0];
        yield ['on', 0.0];
        yield ['off', 0.0];
        yield ['abc', 0.0];
        yield [null, null];
        yield ['0', 0.0];
        yield [-1, -1.0];
        yield ['-1', -1.0];
        yield ['  -1', -1.0];
        yield ['  - 1', 0.0];
        yield ['- 1', 0.0];
        yield [[], null];
    }
}
