<?php

declare(strict_types=1);

namespace PHP\Tests\Collections\Iteration;

use PHP\Collections\Iteration\Iterator;

class SampleIterator extends Iterator
{
    /** @var int The current index */
    private $index;

    /** @var array The values to traverse */
    private $values;

    /**
     * Create a new Sample Iterator.
     *
     * @param array $values The values to traverse
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function hasCurrent(): bool
    {
        return array_key_exists($this->index, $this->values);
    }

    public function getKey(): int
    {
        if (!$this->hasCurrent()) {
            throw new \OutOfBoundsException('There is no key at the current position.');
        }

        return $this->index;
    }

    public function getValue()
    {
        if (!$this->hasCurrent()) {
            throw new \OutOfBoundsException('There is no value at the current position.');
        }

        return $this->values[$this->getKey()];
    }

    public function goToNext(): void
    {
        ++$this->index;
    }
}
