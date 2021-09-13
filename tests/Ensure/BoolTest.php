<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Ensure;

use PHPUnit\Framework\TestCase;
use function Dgame\Cast\Ensure\bool;
use function Dgame\Cast\Ensure\boolify;

final class BoolTest extends TestCase
{
    /**
     * @param mixed      $input
     * @param bool $expected
     *
     * @dataProvider provideBools
     */
    public function testBool(mixed $input, bool $expected): void
    {
        $this->assertSame($expected, bool($input, default: false));
    }

    /**
     * @param mixed      $input
     * @param bool $expected
     *
     * @dataProvider provideBoolify
     */
    public function testBoolify(mixed $input, bool $expected): void
    {
        $this->assertSame($expected, boolify($input, default: false));
    }

    public function provideBools(): iterable
    {
        yield [42, false];
        yield [4.2, false];
        yield ['4.2', false];
        yield ['42', false];
        yield ['  42', false];
        yield ['42  ', false];
        yield ['  42  ', false];
        yield ['  4.2', false];
        yield ['4.2  ', false];
        yield ['  4.2  ', false];
        yield ['42a', false];
        yield ['a42', false];
        yield ['4.2a', false];
        yield ['a4.2', false];
        yield [true, true];
        yield [false, false];
        yield ['true', true];
        yield ['false', false];
        yield ['yes', true];
        yield ['no', false];
        yield ['on', true];
        yield ['off', false];
        yield ['abc', false];
        yield [null, false];
        yield ['1', true];
        yield ['0', false];
        yield [1, true];
        yield [0, false];
        yield [-1, false];
        yield ['-1', false];
        yield ['  -1', false];
        yield ['  - 1', false];
        yield ['- 1', false];
        yield [[], false];
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
        yield [null, false];
        yield ['1', true];
        yield ['0', false];
        yield [1, true];
        yield [0, false];
        yield [-1, true];
        yield ['-1', true];
        yield ['  -1', true];
        yield ['  - 1', true];
        yield ['- 1', true];
        yield [[], false];
    }
}
