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


    /**
     * Test getValue() return values
     * 
     * @dataProvider getValueReturnValuesTestData
     */
    public function testGetValueReturnValue( DictionaryIterator $iterator, string $expectedKey, string $expectedValue )
    {
        $this->assertEquals(
            $expectedKey,
            $iterator->getValue()->getKey(),
            'DictionaryIterator->getValue()->getKey() did not return the correct key.'
        );
        $this->assertEquals(
            $expectedValue,
            $iterator->getValue()->getValue(),
            'DictionaryIterator->getValue()->getValue() did not return the correct value.'
        );
    }

    public function getValueReturnValuesTestData(): array
    {
        $iterator = new DictionaryIterator( new Dictionary( 'string', 'string', [
            'foo' => 'bar',
            'biz' => 'baz',
            'one' => 'two'
        ]));

        return [
            'Unmoved DictionaryIterator' => [
                clone $iterator,
                'foo',
                'bar'
            ],
            'DictionaryIterator => goToNext()' => [
                (function() use ( $iterator ) {
                    $iterator = clone $iterator;
                    $iterator->goToNext();
                    return $iterator;
                })(),
                'biz',
                'baz'
            ],
            'DictionaryIterator => goToNext() => goToNext()' => [
                (function() use ( $iterator ) {
                    $iterator = clone $iterator;
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                'one',
                'two'
            ]
        ];
    }


    /**
     * Test getValue() throws OutOfBoundsException
     */
    public function testGetValueThrowsOutOfBoundsException()
    {
        // Mock hasCurrent() as returning false
        $iterator = $this->getMockBuilder( DictionaryIterator::class )
            ->disableOriginalConstructor()
            ->setMethods([ 'hasCurrent' ])
            ->getMock();
        $iterator->method( 'hasCurrent' )->willReturn( false );

        // Test
        $this->expectException( \OutOfBoundsException::class );
        $iterator->getValue();
    }
}