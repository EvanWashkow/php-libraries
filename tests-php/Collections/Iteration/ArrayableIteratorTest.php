<?php

declare(strict_types=1);

namespace PHP\Tests\Collections\Iteration;

use PHP\Collections\IArrayable;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iteration\IndexedIterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests ArrayableIterator.
 *
 * @internal
 * @coversNothing
 */
class ArrayableIteratorTest extends TestCase
{
    // INHERITANCE

    /**
     * Test inheritance.
     *
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance(string $expectedParent)
    {
        $this->assertInstanceOf(
            $expectedParent,
            new ArrayableIterator($this->createArrayable([1, 2, 3])),
            "ArrayableIterator is not of type \\{$expectedParent}."
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            IndexedIterator::class => [IndexedIterator::class],
        ];
    }

    // __construct()

    /**
     * Test __construct() throws DomainException.
     */
    public function testConstructThrowsDomainException()
    {
        $this->expectException(\DomainException::class);
        new ArrayableIterator(
            $this->createArrayable([1, 2, 3]),
            0,
            0
        );
    }

    /**
     * Test __construct() sets parent constructor values.
     *
     * @dataProvider getParentConstructorTestData
     */
    public function testParentConstructor(int $startingIndex, int $incrementBy)
    {
        // Create Iterator
        $arrayable = $this->createArrayable([1, 2, 3]);
        $iterator = new ArrayableIterator($arrayable, $startingIndex, $incrementBy);

        // goToNext() to test startingIndex and incrementBy
        $iterator->goToNext();

        // Test
        $this->assertEquals(
            ($startingIndex + $incrementBy),
            $iterator->getKey(),
            'ArrayableIterator->getKey() did not return the expected index.'
        );
    }

    public function getParentConstructorTestData(): array
    {
        return [
            'start = 0, increment by = 1' => [0, 1],
            'start = 1, increment by = 1' => [1, 1],
            'start = 2, increment by = -1' => [2, -1],
        ];
    }

    // getValue()

    /**
     * Test getValue() return value and Exception.
     *
     * @dataProvider getIterators
     */
    public function testGetValue(ArrayableIterator $iterator, bool $hasCurrent, ?int $getValue)
    {
        if (null === $getValue) {
            $this->expectException(\OutOfBoundsException::class);
            $iterator->getValue();
        } else {
            $this->assertEquals(
                $getValue,
                $iterator->getValue(),
                'ArrayableIterator->getValue() did not return the expected value.'
            );
        }
    }

    // hasCurrent()

    /**
     * Ensure hasCurrent() returns expected result.
     *
     * @dataProvider getIterators
     */
    public function testHasCurrent(ArrayableIterator $iterator, bool $hasCurrent, ?int $getValue)
    {
        $this->assertEquals(
            $hasCurrent,
            $iterator->hasCurrent(),
            'ArrayableIterator->hasCurrent() did not return the expected result.'
        );
    }

    // SHARED DATA PROVIDERS

    /**
     * Retrieve ArrayableIterators for testing.
     */
    public function getIterators(): array
    {
        // IArrayable->toArray() return values
        $indexedArray = [1, 2, 3];
        $mappedArray = ['a' => 1, 'b' => 2, 'c' => 3];

        return [
            // Example ArrayableIterator for empty IArrayable
            'ArrayableIterator( [], 0 )' => [
                $this->createArrayableIterator([], 0),    // ArrayableIterator
                false,                                      // ->hasCurrent()
                null,                                        // ->getValue()
            ],

            // ArrayableIterator( indexedArray )
            'ArrayableIterator( indexedArray, -1 )' => [
                $this->createArrayableIterator($indexedArray, -1),
                false,
                null,
            ],
            'ArrayableIterator( indexedArray, 0 )' => [
                $this->createArrayableIterator($indexedArray, 0),
                true,
                1,
            ],
            'ArrayableIterator( indexedArray, 2 )' => [
                $this->createArrayableIterator($indexedArray, 2),
                true,
                3,
            ],
            'ArrayableIterator( indexedArray, 3 )' => [
                $this->createArrayableIterator($indexedArray, 3),
                false,
                null,
            ],

            // ArrayableIterator( mappedArray )
            'ArrayableIterator( mappedArray, -1 )' => [
                $this->createArrayableIterator($mappedArray, -1),
                false,
                null,
            ],
            'ArrayableIterator( mappedArray, 0 )' => [
                $this->createArrayableIterator($mappedArray, 0),
                true,
                1,
            ],
            'ArrayableIterator( mappedArray, 2 )' => [
                $this->createArrayableIterator($mappedArray, 2),
                true,
                3,
            ],
            'ArrayableIterator( mappedArray, 3 )' => [
                $this->createArrayableIterator($mappedArray, 3),
                false,
                null,
            ],
        ];
    }

    // UTILITIES

    /**
     * Create an ArrayableIterator instance.
     *
     * @param array $array         The return value of IArrayable->toArray()
     * @param int   $startingIndex The starting index
     * @param int   $incrementBy   The amount to increment the index by on every goToNext()
     */
    private function createArrayableIterator(
        array $array,
        int $startingIndex = 0,
        int $incrementBy = 1
    ): ArrayableIterator {
        return new ArrayableIterator($this->createArrayable($array), $startingIndex, $incrementBy);
    }

    /**
     * Create an IArrayable instance.
     *
     * @param array $array The return value of toArray()
     */
    private function createArrayable(array $array): IArrayable
    {
        $arrayable = $this->createMock(IArrayable::class);
        $arrayable->method('toArray')->willReturn($array);

        return $arrayable;
    }
}
