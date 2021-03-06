<?php

declare(strict_types=1);

namespace Dgame\Cast\Collection;

use ArrayAccess;
use function Dgame\Cast\Assume\collectionOf;
use Iterator;

/**
 * @template T
 * @implements ArrayAccess<int, T>
 * @implements Iterator<int, T>
 */
final class ArrayList implements ArrayAccess, Iterator
{
    /**
     * @var callable(mixed): T
     */
    private $typeEnsurance;
    /**
     * @var T[]
     */
    private array $values;
    private int $offset = 0;

    /**
     * @param callable(mixed): T $typeEnsurance
     * @param T                  ...$values
     */
    public function __construct(callable $typeEnsurance, mixed ...$values)
    {
        $this->typeEnsurance = $typeEnsurance;
        $this->values        = $values === [] ? [] : array_values($values);
    }

    /**
     * @param callable(mixed): T $typeEnsurance
     * @param mixed              ...$values ;
     *
     * @return self<T>|null
     */
    public static function of(callable $typeEnsurance, mixed ...$values): ?self
    {
        $values = collectionOf($typeEnsurance, $values);
        if ($values === null) {
            return null;
        }

        $self         = new self($typeEnsurance);
        $self->values = $values;

        return $self;
    }

    /**
     * @param callable(mixed): T  $typeEnsurance
     * @param array<mixed, mixed> $values
     *
     * @return self<T>
     */
    public static function filtered(callable $typeEnsurance, array $values): self
    {
        $self         = new self($typeEnsurance);
        $self->values = filter($typeEnsurance, $values);

        return $self;
    }

    /**
     * @param callable(mixed): bool $predicate
     *
     * @return bool
     */
    public function all(callable $predicate): bool
    {
        return all($this->values, $predicate);
    }

    /**
     * @param callable(mixed): bool $predicate
     *
     * @return bool
     */
    public function any(callable $predicate): bool
    {
        return any($this->values, $predicate);
    }

    public function isEmpty(): bool
    {
        return count($this->values) === 0;
    }

    public function isNotEmpty(): bool
    {
        return count($this->values) !== 0;
    }

    /**
     * @param callable(mixed): T $predicate
     *
     * @return self<T>
     */
    public function filter(callable $predicate): self
    {
        $self         = new self($this->typeEnsurance);
        $self->values = array_filter($this->values, $predicate);

        return $self;
    }

    /**
     * @param callable(mixed): T $predicate
     *
     * @return self<T>
     */
    public function map(callable $predicate): self
    {
        $self         = new self($this->typeEnsurance);
        $self->values = array_map($predicate, $this->values);

        return $self;
    }

    /**
     * @param int      $offset
     * @param int|null $length
     *
     * @return self<T>
     */
    public function slice(int $offset, ?int $length = null): self
    {
        $self         = new self($this->typeEnsurance);
        $self->values = array_slice($this->values, $offset, $length);

        return $self;
    }

    /**
     * @return T[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return iterable<T>
     */
    public function yield(): iterable
    {
        yield from $this->values;
    }

    /**
     * @param int $offset
     * @param T   $default
     *
     * @return T
     */
    public function getAt(mixed $offset, mixed $default): mixed
    {
        return $this->values[$offset] ?? $default;
    }

    /**
     * @param int $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->values);
    }

    /**
     * @param int $offset
     *
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->values[$offset];
    }

    /**
     * @param int|null $offset
     * @param T        $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $value = ($this->typeEnsurance)($value);
        assert($value !== null);

        $this->values[$offset] = $value;
    }

    /**
     * @param int $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->values[$offset]);
    }

    /**
     * @return T
     */
    public function current(): mixed
    {
        return $this->values[$this->offset];
    }

    public function key(): int
    {
        return $this->offset;
    }

    public function next(): void
    {
        ++$this->offset;
    }

    public function rewind(): void
    {
        $this->offset = 0;
    }

    public function valid(): bool
    {
        return $this->offset < count($this->values);
    }
}
