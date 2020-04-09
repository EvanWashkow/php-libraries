<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Collection;
use PHP\Collections\Dictionary;
use PHP\Collections\Iterators\DictionaryIterator;
use PHP\Collections\Iterators\IteratedKeyValue;
use PHP\Collections\Iterators\SequenceIterator;
use PHP\Collections\Sequence;
use PHP\Iteration\IIterable;
use PHPUnit\Framework\TestCase;

/**
 * Tests Collections' IIterable-ity
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


    /**
     * Test Collections in foreach() loop
     * 
     * @dataProvider getForEachCollectionTestData
     */
    public function testForEachCollection( Collection $collection, $expectedKeys, $expectedValues )
    {
        // Retains list of iterated values
        $outerKeys   = [];
        $outerValues = [];
        $innerKeys   = null;
        $innerValues = null;

        // Do outer loop
        foreach ( $collection as $outerKey => $outerValue ) {
            $outerKeys[]   = $outerKey;
            $outerValues[] = $outerValue;

            // Reset inner lists
            $innerKeys   = [];
            $innerValues = [];

            // Do inner loop
            foreach ( $collection as $innerKey => $innerValue ) {
                $innerKeys[]   = $innerKey;
                $innerValues[] = $innerValue;
            }
        }

        // Test outer keys and values
        $this->assertEquals(
            $expectedKeys,
            $outerKeys,
            'Outer foreach( Collection ) loop did not return the expected keys.'
        );
        $this->assertEquals(
            $expectedValues,
            $outerValues,
            'Outer foreach( Collection ) loop did not return the expected values.'
        );

        // Test inner keys and values
        $this->assertEquals(
            $expectedKeys,
            $innerKeys,
            'Inner foreach( Collection ) loop did not return the expected keys.'
        );
        $this->assertEquals(
            $expectedValues,
            $innerValues,
            'Inner foreach( Collection ) loop did not return the expected values.'
        );
    }

    public function getForEachCollectionTestData(): array
    {
        return [
            'Dictionary' => [
                new Dictionary( 'string', 'string', [
                    'foo'   => 'bar',
                    'biz'   => 'baz',
                    'one'   => '1',
                    'two'   => '2',
                    'three' => '3'
                ]),
                [ 0, 1, 2, 3, 4 ],
                [
                    new IteratedKeyValue( 'foo',   'bar' ),
                    new IteratedKeyValue( 'biz',   'baz' ),
                    new IteratedKeyValue( 'one',   '1' ),
                    new IteratedKeyValue( 'two',   '2' ),
                    new IteratedKeyValue( 'three', '3' )
                ]
            ],
            'Sequence' => [
                new Sequence( 'string', [
                    'foo', 'bar', 'biz', 'baz', 'one', 'two', 'three'
                ]),
                [ 0, 1, 2, 3, 4, 5, 6 ],
                [
                    new IteratedKeyValue( 0, 'foo' ),
                    new IteratedKeyValue( 1, 'bar' ),
                    new IteratedKeyValue( 2, 'biz' ),
                    new IteratedKeyValue( 3, 'baz' ),
                    new IteratedKeyValue( 4, 'one' ),
                    new IteratedKeyValue( 5, 'two' ),
                    new IteratedKeyValue( 6, 'three' )
                ]
            ]
        ];
    }
}