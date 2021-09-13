<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Ensure;

use PHPUnit\Framework\TestCase;
use function Dgame\Cast\Ensure\float;
use function Dgame\Cast\Ensure\floatify;

final class FloatTest extends TestCase
{
    /**
     * @param mixed      $input
     * @param float $expected
     *
     * @dataProvider provideFloats
     */
    public function testFloat(mixed $input, float $expected): void
    {
        $this->assertSame($expected, float($input, default: 0.0));
    }

    /**
     * @param mixed      $input
     * @param float $expected
     *
     * @dataProvider provideFloatify
     */
    public function testFloatify(mixed $input, float $expected): void
    {
        $this->assertSame($expected, floatify($input, default: 0.0));
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
        yield ['42a', 0.0];
        yield ['a42', 0.0];
        yield ['4.2a', 0.0];
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
        yield [null, 0.0];
        yield ['0', 0.0];
        yield [-1, -1.0];
        yield ['-1', -1.0];
        yield ['  -1', -1.0];
        yield ['  - 1', 0.0];
        yield ['- 1', 0.0];
        yield [[], 0.0];
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
        yield [null, 0.0];
        yield ['0', 0.0];
        yield [-1, -1.0];
        yield ['-1', -1.0];
        yield ['  -1', -1.0];
        yield ['  - 1', 0.0];
        yield ['- 1', 0.0];
        yield [[], 0.0];
    }
}
