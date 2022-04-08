<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Assume;

use PHPUnit\Framework\TestCase;
use function Dgame\Cast\Assume\negative;
use function Dgame\Cast\Assume\positive;
use function Dgame\Cast\Assume\unsigned;

final class IntegerRangeTest extends TestCase
{
    /**
     * @param mixed    $input
     * @param int|null $expected
     *
     * @dataProvider provideUnsignedInts
     */
    public function testUnsignedInt(mixed $input, ?int $expected): void
    {
        $this->assertSame($expected, unsigned($input));
    }

    /**
     * @param mixed    $input
     * @param int|null $expected
     *
     * @dataProvider providePositiveInts
     */
    public function testPositiveInt(mixed $input, ?int $expected): void
    {
        $this->assertSame($expected, positive($input));
    }

    /**
     * @param mixed    $input
     * @param int|null $expected
     *
     * @dataProvider provideNegativeInts
     */
    public function testNegativeInt(mixed $input, ?int $expected): void
    {
        $this->assertSame($expected, negative($input));
    }

    public function provideUnsignedInts(): iterable
    {
        foreach (range(0, 25, 2) as $i) {
            yield [$i, (int) $i];
        }

        foreach (range(-1, -25, 2) as $i) {
            yield [$i, null];
        }

        yield [-0, 0];
        yield [0.0, 0];
        yield [-0.0, 0];
        yield [0.5, 0];
        yield [1.5, 1];
        yield [2.5, 2];
    }

    public function providePositiveInts(): iterable
    {
        foreach (range(1, 25, 2) as $i) {
            yield [$i, (int) $i];
        }

        foreach (range(0, -25, 2) as $i) {
            yield [$i, null];
        }

        yield [-0, null];
        yield [0.0, null];
        yield [-0.0, null];
        yield [0.5, null];
        yield [1.5, 1];
        yield [2.5, 2];
    }

    public function provideNegativeInts(): iterable
    {
        foreach (range(0, 25, 2) as $i) {
            yield [$i, null];
        }

        foreach (range(-1, -25, 2) as $i) {
            yield [$i, (int) $i];
        }

        yield [0.0, null];
        yield [-0.0, null];
    }
}
