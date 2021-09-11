<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Assume;

use PHPUnit\Framework\TestCase;
use function Dgame\Cast\Assume\int;
use function Dgame\Cast\Assume\intify;

final class IntTest extends TestCase
{
    /**
     * @param mixed    $input
     * @param int|null $expected
     *
     * @dataProvider provideInts
     */
    public function testInt(mixed $input, ?int $expected): void
    {
        $this->assertSame($expected, int($input));
    }

    /**
     * @param mixed    $input
     * @param int|null $expected
     *
     * @dataProvider provideIntify
     */
    public function testIntify(mixed $input, ?int $expected): void
    {
        $this->assertSame($expected, intify($input));
    }

    public function provideInts(): iterable
    {
        yield [42, 42];
        yield [4.2, null];
        yield ['4.2', null];
        yield ['42', 42];
        yield ['  42', 42];
        yield ['42  ', 42];
        yield ['  42  ', 42];
        yield ['42a', null];
        yield ['a42', null];
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
        yield ['0', 0];
        yield [-1, -1];
        yield ['-1', -1];
        yield ['  -1', -1];
        yield ['  - 1', null];
        yield ['- 1', null];
        yield [[], null];
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
        yield ['true', 1];
        yield ['false', 0];
        yield ['yes', 1];
        yield ['no', 0];
        yield ['on', 1];
        yield ['off', 0];
        yield ['abc', 0];
        yield [null, 0];
        yield ['0', 0];
        yield [-1, -1];
        yield ['-1', -1];
        yield ['  -1', -1];
        yield ['  - 1', 0];
        yield ['- 1', 0];
        yield [[], null];
    }
}
