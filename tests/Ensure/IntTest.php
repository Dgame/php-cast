<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Ensure;

use function Dgame\Cast\Ensure\int;
use function Dgame\Cast\Ensure\intify;
use PHPUnit\Framework\TestCase;

final class IntTest extends TestCase
{
    /**
     * @param mixed    $input
     * @param int $expected
     *
     * @dataProvider provideInts
     */
    public function testInt(mixed $input, int $expected): void
    {
        $this->assertSame($expected, int($input, default: 0));
    }

    /**
     * @param mixed    $input
     * @param int $expected
     *
     * @dataProvider provideIntify
     */
    public function testIntify(mixed $input, int $expected): void
    {
        $this->assertSame($expected, intify($input, default: 0));
    }

    public function provideInts(): iterable
    {
        yield [42, 42];
        yield [4.2, 0];
        yield ['4.2', 0];
        yield ['42', 42];
        yield ['  42', 42];
        yield ['42  ', 42];
        yield ['  42  ', 42];
        yield ['42a', 0];
        yield ['a42', 0];
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
        yield ['0', 0];
        yield [-1, -1];
        yield ['-1', -1];
        yield ['  -1', -1];
        yield ['  - 1', 0];
        yield ['- 1', 0];
        yield [[], 0];
    }

    public function provideIntify(): iterable
    {
        yield [42, 42];
        yield [4.2, 4];
        yield ['4.2', 4];
        yield ['42', 42];
        yield ['  42', 42];
        yield ['42  ', 42];
        yield ['  42  ', 42];
        yield ['42a', 42];
        yield ['a42', 0];
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
        yield ['0', 0];
        yield [-1, -1];
        yield ['-1', -1];
        yield ['  -1', -1];
        yield ['  - 1', 0];
        yield ['- 1', 0];
        yield [[], 0];
    }
}
