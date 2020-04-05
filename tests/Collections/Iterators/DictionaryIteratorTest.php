<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Dictionary;
use PHP\Collections\Iterators\DictionaryIterator;
use PHP\Iteration\IndexedIterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests the DictionaryIterator implementation
 */
class DictionaryIteratorTest extends TestCase
{



    /**
     * Ensure DictionaryIterator is an instance of a IndexedIterator
     */
    public function testIsIndexedIterator()
    {
        $this->assertInstanceOf(
            IndexedIterator::class,
            new DictionaryIterator( new Dictionary( 'string', 'string' )),
            'DictionaryIterator is not an IndexedIterator instance.'
        );
    }


    /**
     * Test __construct() starting index is zero
     */
    public function testConstructStartingIndex()
    {
        $this->assertEquals(
            0,
            ( new DictionaryIterator( new Dictionary( 'string', 'string' )))->getKey(),
            'DictionaryIterator->getKey() did not return zero (0).'
        );
    }


    /**
     * Test hasCurrent()
     * 
     * @dataProvider getHasCurrentTestData
     */
    public function testHasCurrent( DictionaryIterator $iterator, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $iterator->hasCurrent(),
            'DictionaryIterator->hasCurrent() returned the wrong value'
        );
    }

    public function getHasCurrentTestData(): array
    {
        return [
            'Empty Dictionary' => [
                new DictionaryIterator( new Dictionary( 'string', 'string' ) ),
                false
            ],
            'Dictionary with one value' => [
                new DictionaryIterator( new Dictionary( 'string', 'string', [ 'foo' => 'bar' ] ) ),
                true
            ],
            'Dictionary with one value => goToNext()' => [
                (function() {
                    $iterator = new DictionaryIterator(
                        new Dictionary( 'string', 'string', [ 'foo' => 'bar' ] )
                    );
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false
            ],
            'Dictionary with two values' => [
                new DictionaryIterator( new Dictionary( 'string', 'string', [ 'foo' => 'bar', 'biz' => 'baz' ] ) ),
                true
            ],
            'Dictionary with two values => goToNext()' => [
                (function() {
                    $iterator = new DictionaryIterator(
                        new Dictionary( 'string', 'string', [ 'foo' => 'bar', 'biz' => 'baz' ] )
                    );
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true
            ],
            'Dictionary with two values => goToNext() => goToNext()' => [
                (function() {
                    $iterator = new DictionaryIterator(
                        new Dictionary( 'string', 'string', [ 'foo' => 'bar', 'biz' => 'baz' ] )
                    );
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false
            ]
        ];
    }
}