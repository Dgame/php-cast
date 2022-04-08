<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Assume;

use PHPUnit\Framework\TestCase;
use function Dgame\Cast\Assume\bool;
use function Dgame\Cast\Assume\boolify;
use function Dgame\Cast\Assume\bools;

final class BoolTest extends TestCase
{
    /**
     * @param mixed     $input
     * @param bool|null $expected
     *
     * @dataProvider provideBools
     */
    public function testBool(mixed $input, ?bool $expected): void
    {
        $this->assertSame($expected, bool($input));
    }

    /**
     * @param mixed     $input
     * @param bool|null $expected
     *
     * @dataProvider provideBoolify
     */
    public function testBoolify(mixed $input, ?bool $expected): void
    {
        $this->assertSame($expected, boolify($input));
    }

    /**
     * @param array      $input
     * @param array|null $expected
     *
     * @dataProvider provideBoolList
     */
    public function testBools(array $input, ?array $expected): void
    {
        $this->assertSame($expected, bools($input));
    }

    public function provideBools(): iterable
    {
        yield [42, null];
        yield [4.2, null];
        yield ['4.2', null];
        yield ['42', null];
        yield ['  42', null];
        yield ['42  ', null];
        yield ['  42  ', null];
        yield ['  4.2', null];
        yield ['4.2  ', null];
        yield ['  4.2  ', null];
        yield ['42a', null];
        yield ['a42', null];
        yield ['4.2a', null];
        yield ['a4.2', null];
        yield [true, true];
        yield [false, false];
        yield ['true', true];
        yield ['false', false];
        yield ['yes', true];
        yield ['no', false];
        yield ['on', true];
        yield ['off', false];
        yield ['abc', null];
        yield [null, null];
        yield ['1', true];
        yield ['0', false];
        yield [1, true];
        yield [0, false];
        yield [-1, null];
        yield ['-1', null];
        yield ['  -1', null];
        yield ['  - 1', null];
        yield ['- 1', null];
        yield [[], null];
    }

    public function provideBoolify(): iterable
    {
        yield [42, true];
        yield [4.2, true];
        yield ['4.2', true];
        yield ['42', true];
        yield ['  42', true];
        yield ['42  ', true];
        yield ['  42  ', true];
        yield ['  4.2', true];
        yield ['4.2  ', true];
        yield ['  4.2  ', true];
        yield ['42a', true];
        yield ['a42', true];
        yield ['4.2a', true];
        yield ['a4.2', true];
        yield [true, true];
        yield [false, false];
        yield ['true', true];
        yield ['false', false];
        yield ['yes', true];
        yield ['no', false];
        yield ['on', true];
        yield ['off', false];
        yield ['abc', true];
        yield [null, null];
        yield ['1', true];
        yield ['0', false];
        yield [1, true];
        yield [0, false];
        yield [-1, true];
        yield ['-1', true];
        yield ['  -1', true];
        yield ['  - 1', true];
        yield ['- 1', true];
        yield [[], null];
    }

    public function provideBoolList(): iterable
    {
        yield [
            [1, 2, 3],
            null
        ];

        yield [
            [-1, 0, 1],
            null
        ];

        yield [
            ['yes', 'no'],
            [true, false]
        ];

        yield [
            [false => 'yes', true => 'no'],
            [true, false]
        ];

        yield [
            [1, 0],
            [true, false]
        ];

        yield [
            ['1', '0'],
            [true, false]
        ];

        yield [
            ['a', true],
            null
        ];

        yield [
            [],
            []
        ];
    }
}
