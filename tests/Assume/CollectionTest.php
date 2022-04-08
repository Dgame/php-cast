<?php

declare(strict_types=1);

namespace Dgame\Cast\Test\Assume;

use PHPUnit\Framework\TestCase;
use function Dgame\Cast\Assume\collection;
use function Dgame\Cast\Assume\collectionOf;
use function Dgame\Cast\Assume\collectionOfNonEmpty;
use function Dgame\Cast\Assume\listOf;
use function Dgame\Cast\Assume\listOfNonEmpty;
use function Dgame\Cast\Assume\mapOf;
use function Dgame\Cast\Assume\mapOfNonEmpty;
use function Dgame\Cast\Collection\bools;
use function Dgame\Cast\Collection\filter;
use function Dgame\Cast\Collection\filterMap;
use function Dgame\Cast\Collection\floats;
use function Dgame\Cast\Collection\ints;
use function Dgame\Cast\Collection\strings;

final class CollectionTest extends TestCase
{
    /**
     * @param mixed      $value
     * @param array|null $expected
     *
     * @dataProvider provideCollection
     */
    public function testCollection(mixed $value, ?array $expected): void
    {
        $this->assertSame($expected, collection($value));
    }

    /**
     * @param mixed      $value
     * @param callable   $type
     * @param array|null $expected
     *
     * @dataProvider provideCollectionOf
     */
    public function testCollectionOf(mixed $value, callable $type, ?array $expected): void
    {
        $this->assertSame($expected, collectionOf($type, $value));
    }

    /**
     * @param mixed      $value
     * @param callable   $type
     * @param array|null $expected
     *
     * @dataProvider provideCollectionOfNonEmpty
     */
    public function testCollectionOfNonEmpty(mixed $value, callable $type, ?array $expected): void
    {
        $this->assertSame($expected, collectionOfNonEmpty($type, $value));
    }

    /**
     * @param mixed      $value
     * @param callable   $type
     * @param array|null $expected
     *
     * @dataProvider provideListOf
     */
    public function testListOf(mixed $value, callable $type, ?array $expected): void
    {
        $this->assertSame($expected, listOf($type, $value));
    }

    /**
     * @param mixed      $value
     * @param callable   $type
     * @param array|null $expected
     *
     * @dataProvider provideListOfNonEmpty
     */
    public function testListOfNonEmpty(mixed $value, callable $type, ?array $expected): void
    {
        $this->assertSame($expected, listOfNonEmpty($type, $value));
    }

    /**
     * @param mixed      $value
     * @param callable   $type
     * @param array|null $expected
     *
     * @dataProvider provideMapOf
     */
    public function testMapOf(mixed $value, callable $type, ?array $expected): void
    {
        $this->assertSame($expected, mapOf($type, $value));
    }

    /**
     * @param mixed      $value
     * @param callable   $type
     * @param array|null $expected
     *
     * @dataProvider provideMapOfNonEmpty
     */
    public function testMapOfNonEmpty(mixed $value, callable $type, ?array $expected): void
    {
        $this->assertSame($expected, mapOfNonEmpty($type, $value));
    }

    /**
     * @param array      $values
     * @param callable   $type
     * @param array|null $expected
     *
     * @dataProvider provideFilter
     */
    public function testFilter(array $values, callable $type, ?array $expected): void
    {
        $this->assertSame($expected, filter($type, $values));
    }

    /**
     * @param array      $values
     * @param callable   $type
     * @param callable   $callback
     * @param array|null $expected
     *
     * @dataProvider provideFilterMap
     */
    public function testFilterMap(array $values, callable $type, callable $callback, ?array $expected): void
    {
        $this->assertSame($expected, filterMap($type, $values, $callback));
    }

    /**
     * @param array  $values
     * @param string $type
     * @param array  $expected
     *
     * @dataProvider provideInts
     */
    public function testInts(array $values, string $type, array $expected): void
    {
        match (true) {
            str_ends_with($type, 'int') => $this->assertSame($expected, ints($values)),
            str_ends_with($type, 'float') => $this->assertSame($expected, floats($values)),
            str_ends_with($type, 'bool') => $this->assertSame($expected, bools($values)),
            str_ends_with($type, 'string') => $this->assertSame($expected, strings($values)),
            default => $this->fail('Unknown type: ' . $type)
        };
    }

    public function provideCollection(): iterable
    {
        yield [null, null];
        yield [42, null];
        yield [4.2, null];
        yield [true, null];
        yield [[], []];
        yield [[null], [null]];
        yield [[''], ['']];
        yield [['  '], ['  ']];
        yield [[1, 2, 3], [1, 2, 3]];
        yield [[1, '2', 3], [1, '2', 3]];
        yield [[1, '  2', 3], [1, '  2', 3]];
        yield [['a' => 1, 'b' => 2, 'c' => 3], ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], ['a' => 1, 'b' => '2', 'c' => 3]];
        yield [['a' => 1, 'b' => 'a', 'c' => 3], ['a' => 1, 'b' => 'a', 'c' => 3]];
    }

    public function provideCollectionOf(): iterable
    {
        yield [null, '\Dgame\Cast\Assume\int', null];
        yield [42, '\Dgame\Cast\Assume\int', null];
        yield [4.2, '\Dgame\Cast\Assume\int', null];
        yield [true, '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\int', []];
        yield [[null], '\Dgame\Cast\Assume\int', null];
        yield [[''], '\Dgame\Cast\Assume\int', null];
        yield [['1'], '\Dgame\Cast\Assume\int', [1]];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', null];
        yield [['  '], '\Dgame\Cast\Assume\int', null];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\string', []];
        yield [[null], '\Dgame\Cast\Assume\string', null];
        yield [[''], '\Dgame\Cast\Assume\string', ['']];
        yield [['1'], '\Dgame\Cast\Assume\string', ['1']];
        yield [['1', '2'], '\Dgame\Cast\Assume\string', ['1', '2']];
        yield [['  '], '\Dgame\Cast\Assume\string', ['  ']];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\string', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\string', null];
    }

    public function provideCollectionOfNonEmpty(): iterable
    {
        yield [null, '\Dgame\Cast\Assume\int', null];
        yield [42, '\Dgame\Cast\Assume\int', null];
        yield [4.2, '\Dgame\Cast\Assume\int', null];
        yield [true, '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\int', null];
        yield [[null], '\Dgame\Cast\Assume\int', null];
        yield [[''], '\Dgame\Cast\Assume\int', null];
        yield [['1'], '\Dgame\Cast\Assume\int', [1]];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', null];
        yield [['  '], '\Dgame\Cast\Assume\int', null];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\string', null];
        yield [[null], '\Dgame\Cast\Assume\string', null];
        yield [[''], '\Dgame\Cast\Assume\string', ['']];
        yield [['1'], '\Dgame\Cast\Assume\string', ['1']];
        yield [['1', '2'], '\Dgame\Cast\Assume\string', ['1', '2']];
        yield [['  '], '\Dgame\Cast\Assume\string', ['  ']];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\string', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\string', null];
    }

    public function provideListOf(): iterable
    {
        yield [null, '\Dgame\Cast\Assume\int', null];
        yield [42, '\Dgame\Cast\Assume\int', null];
        yield [4.2, '\Dgame\Cast\Assume\int', null];
        yield [true, '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\int', []];
        yield [[null], '\Dgame\Cast\Assume\int', null];
        yield [[''], '\Dgame\Cast\Assume\int', null];
        yield [['1'], '\Dgame\Cast\Assume\int', [1]];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', null];
        yield [['  '], '\Dgame\Cast\Assume\int', null];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\string', []];
        yield [[null], '\Dgame\Cast\Assume\string', null];
        yield [[''], '\Dgame\Cast\Assume\string', ['']];
        yield [['1'], '\Dgame\Cast\Assume\string', ['1']];
        yield [['1', '2'], '\Dgame\Cast\Assume\string', ['1', '2']];
        yield [['  '], '\Dgame\Cast\Assume\string', ['  ']];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\string', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\string', null];
    }

    public function provideListOfNonEmpty(): iterable
    {
        yield [null, '\Dgame\Cast\Assume\int', null];
        yield [42, '\Dgame\Cast\Assume\int', null];
        yield [4.2, '\Dgame\Cast\Assume\int', null];
        yield [true, '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\int', null];
        yield [[null], '\Dgame\Cast\Assume\int', null];
        yield [[''], '\Dgame\Cast\Assume\int', null];
        yield [['1'], '\Dgame\Cast\Assume\int', [1]];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', null];
        yield [['  '], '\Dgame\Cast\Assume\int', null];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\string', null];
        yield [[null], '\Dgame\Cast\Assume\string', null];
        yield [[''], '\Dgame\Cast\Assume\string', ['']];
        yield [['1'], '\Dgame\Cast\Assume\string', ['1']];
        yield [['1', '2'], '\Dgame\Cast\Assume\string', ['1', '2']];
        yield [['  '], '\Dgame\Cast\Assume\string', ['  ']];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\string', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\string', null];
    }

    public function provideMapOf(): iterable
    {
        yield [null, '\Dgame\Cast\Assume\int', null];
        yield [42, '\Dgame\Cast\Assume\int', null];
        yield [4.2, '\Dgame\Cast\Assume\int', null];
        yield [true, '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\int', []];
        yield [[null], '\Dgame\Cast\Assume\int', null];
        yield [[''], '\Dgame\Cast\Assume\int', null];
        yield [['1'], '\Dgame\Cast\Assume\int', null];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', null];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', null];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', null];
        yield [['  '], '\Dgame\Cast\Assume\int', null];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', null];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', null];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', null];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\string', []];
        yield [[null], '\Dgame\Cast\Assume\string', null];
        yield [[''], '\Dgame\Cast\Assume\string', null];
        yield [['1'], '\Dgame\Cast\Assume\string', null];
        yield [['1', '2'], '\Dgame\Cast\Assume\string', null];
        yield [['  '], '\Dgame\Cast\Assume\string', null];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\string', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\string', null];
    }

    public function provideMapOfNonEmpty(): iterable
    {
        yield [null, '\Dgame\Cast\Assume\int', null];
        yield [42, '\Dgame\Cast\Assume\int', null];
        yield [4.2, '\Dgame\Cast\Assume\int', null];
        yield [true, '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\int', null];
        yield [[null], '\Dgame\Cast\Assume\int', null];
        yield [[''], '\Dgame\Cast\Assume\int', null];
        yield [['1'], '\Dgame\Cast\Assume\int', null];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', null];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', null];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', null];
        yield [['  '], '\Dgame\Cast\Assume\int', null];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', null];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', null];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', null];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', null];
        yield [[], '\Dgame\Cast\Assume\string', null];
        yield [[null], '\Dgame\Cast\Assume\string', null];
        yield [[''], '\Dgame\Cast\Assume\string', null];
        yield [['1'], '\Dgame\Cast\Assume\string', null];
        yield [['1', '2'], '\Dgame\Cast\Assume\string', null];
        yield [['  '], '\Dgame\Cast\Assume\string', null];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\string', null];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\string', null];
    }

    public function provideFilter(): iterable
    {
        yield [[], '\Dgame\Cast\Assume\int', []];
        yield [[null], '\Dgame\Cast\Assume\int', []];
        yield [[''], '\Dgame\Cast\Assume\int', []];
        yield [['1'], '\Dgame\Cast\Assume\int', [1]];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', [1]];
        yield [['  '], '\Dgame\Cast\Assume\int', []];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', [0 => 1, 2 => 3]];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', ['a' => 1, 'c' => 3]];
        yield [[], '\Dgame\Cast\Assume\string', []];
        yield [[null], '\Dgame\Cast\Assume\string', []];
        yield [[''], '\Dgame\Cast\Assume\string', ['']];
        yield [['1'], '\Dgame\Cast\Assume\string', ['1']];
        yield [['1', '2'], '\Dgame\Cast\Assume\string', ['1', '2']];
        yield [['  '], '\Dgame\Cast\Assume\string', ['  ']];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\string', []];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\string', []];
    }

    public function provideFilterMap(): iterable
    {
        yield [[], '\Dgame\Cast\Assume\int', 'trim', []];
        yield [[null], '\Dgame\Cast\Assume\int', 'trim', []];
        yield [[''], '\Dgame\Cast\Assume\int', 'trim', []];
        yield [['1'], '\Dgame\Cast\Assume\int', 'trim', [1]];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', 'trim', [1, 2]];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', 'trim', [1, 2]];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', 'trim', [1]];
        yield [['  '], '\Dgame\Cast\Assume\int', 'trim', []];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', 'trim', [1, 2, 3]];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', 'trim', [1, 2, 3]];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', 'trim', [1, 2, 3]];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', 'trim', [0 => 1, 2 => 3]];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', 'trim', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', 'trim', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', 'trim', ['a' => 1, 'b' => 2, 'c' => 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', 'trim', ['a' => 1, 'c' => 3]];
        yield [[], '\Dgame\Cast\Assume\string', 'trim', []];
        yield [[null], '\Dgame\Cast\Assume\string', 'trim', []];
        yield [[''], '\Dgame\Cast\Assume\string', 'trim', ['']];
        yield [['1'], '\Dgame\Cast\Assume\string', 'trim', ['1']];
        yield [['1', '2'], '\Dgame\Cast\Assume\string', 'trim', ['1', '2']];
        yield [['1', ' 2  '], '\Dgame\Cast\Assume\string', 'trim', ['1', '2']];
        yield [[' foo  ', 'bar  ', '  quatz'], '\Dgame\Cast\Assume\string', 'trim', ['foo', 'bar', 'quatz']];
        yield [[' foo  ', 'bar  ', '  quatz'], '\Dgame\Cast\Assume\int', 'trim', []];
        yield [['  '], '\Dgame\Cast\Assume\string', 'trim', ['']];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\string', 'trim', []];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\string', 'trim', []];
    }

    public function provideInts(): iterable
    {
        yield [[42], '\Dgame\Cast\Assume\int', [42]];
        yield [[4.2], '\Dgame\Cast\Assume\int', []];
        yield [[true], '\Dgame\Cast\Assume\int', [1]];
        yield [[false], '\Dgame\Cast\Assume\int', []];
        yield [[], '\Dgame\Cast\Assume\int', []];
        yield [[null], '\Dgame\Cast\Assume\int', []];
        yield [[''], '\Dgame\Cast\Assume\int', []];
        yield [['1'], '\Dgame\Cast\Assume\int', [1]];
        yield [['1', '2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', '  2'], '\Dgame\Cast\Assume\int', [1, 2]];
        yield [['1', 'a2'], '\Dgame\Cast\Assume\int', [1]];
        yield [['  '], '\Dgame\Cast\Assume\int', []];
        yield [[1, 2, 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, '  2', 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [[1, 'a', 3], '\Dgame\Cast\Assume\int', [1, 3]];
        yield [['a' => 1, 'b' => 2, 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => '2', 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => '  2', 'c' => 3], '\Dgame\Cast\Assume\int', [1, 2, 3]];
        yield [['a' => 1, 'b' => 'b', 'c' => 3], '\Dgame\Cast\Assume\int', [1, 3]];
    }
}
