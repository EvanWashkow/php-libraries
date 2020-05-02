<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Collection;
use PHP\Collections\Dictionary;
use PHP\Collections\Iterators\DictionaryIterator;
use PHP\Collections\Iteration\SequenceIterator;
use PHP\Collections\Sequence;
use PHP\Collections\Iteration\IIterable;
use PHPUnit\Framework\TestCase;

/**
 * Tests Collections' IIterable-ity
 * 
 * Note: don't need to test Collections in a foreach() loop here, since this functionality is verified in IItetrableTest
 * and in the tests for each Collection's Iterator. The IIteratorTest proves that loops work correctly on the Iterators
 * (provided they are correct), and the Collection Iterator tests prove the Iterator's correctness.
 */
class IIterableCollectionsTest extends TestCase
{


    /**
     * Ensure Collections are IIterable
     */
    public function testIsIIterable()
    {
        $collection = $this->createMock( Collection::class );
        $this->assertInstanceOf(
            IIterable::class,
            $collection,
            'Collection is not IIterable.'
        );
    }


    /**
     * Ensure getIterator() returns the expected Iterator
     * 
     * @dataProvider getIteratorReturnTestData
     */
    public function testGetIteratorReturn( Collection $collection, string $expectedIteratorClass )
    {
        $this->assertInstanceOf(
            $expectedIteratorClass,
            $collection->getIterator(),
            'Collection->getIterator() did not return the expected Iterator class instance.'
        );
    }

    public function getIteratorReturnTestData(): array
    {
        return [
            'Dictionary' => [
                new Dictionary( 'string', 'string' ),
                DictionaryIterator::class
            ],
            'Sequence' => [
                new Sequence( 'int' ),
                SequenceIterator::class
            ]
        ];
    }
}