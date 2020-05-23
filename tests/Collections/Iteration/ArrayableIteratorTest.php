<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iteration;

use PHP\Collections\IArrayable;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iteration\IndexedIterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests ArrayableIterator
 */
class ArrayableIteratorTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                    INHERITANCE
    *******************************************************************************************************************/


    /**
     * Test inheritance
     * 
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance( string $expectedParent )
    {
        $this->assertInstanceOf(
            $expectedParent,
            new ArrayableIterator( $this->createArrayable( [ 1, 2, 3 ] ) ),
            "ArrayableIterator is not of type \\{$expectedParent}."
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            IndexedIterator::class => [ IndexedIterator::class ]
        ];
    }




    /*******************************************************************************************************************
    *                                                   __construct()
    *******************************************************************************************************************/


    /**
     * Test __construct() throws DomainException
     */
    public function testConstructThrowsDomainException()
    {
        $this->expectException( \DomainException::class );
        new ArrayableIterator(
            $this->createArrayable( [ 1, 2, 3 ] ),
            0,
            0
        );
    }


    /**
     * Test __construct() sets parent constructor values
     * 
     * @dataProvider getParentConstructorTestData
     */
    public function testParentConstructor( int $startingIndex, int $incrementBy )
    {
        // Create Iterator
        $arrayable = $this->createArrayable( [ 1, 2, 3 ] );
        $iterator  = new ArrayableIterator( $arrayable, $startingIndex, $incrementBy );

        // goToNext() to test startingIndex and incrementBy
        $iterator->goToNext();

        // Test
        $this->assertEquals(
            ( $startingIndex + $incrementBy ),
            $iterator->getKey(),
            'ArrayableIterator->getKey() did not return the expected index.'
        );
    }

    public function getParentConstructorTestData(): array
    {
        return [
            'start = 0, increment by = 1'  => [ 0, 1 ],
            'start = 1, increment by = 1'  => [ 1, 1 ],
            'start = 2, increment by = -1' => [ 2, -1 ]
        ];
    }




    /*******************************************************************************************************************
    *                                                     getValue()
    *******************************************************************************************************************/


    /**
     * Ensure getValue() throws \OutOfBoundsException when hasCurrent() returns false
     */
    public function testGetValueException()
    {
        // Create IArrayable object instance
        $arrayable = $this->createArrayable( [ 1, 2, 3 ] );

        // Mock ArrayableIterator->hasCurrent() returns false
        $arrayableIterator = $this->getMockBuilder( ArrayableIterator::class )
            ->setConstructorArgs([ $arrayable ])
            ->setMethods([ 'hasCurrent' ])
            ->getMock();
        $arrayableIterator->method( 'hasCurrent' )->willReturn( false );

        // Run test
        $this->expectException( \OutOfBoundsException::class );
        $arrayableIterator->getValue();
    }


    /**
     * Test getValue() return value
     * 
     * @dataProvider getGetValueReturnValueTestData
     */
    public function testGetValueReturnValue( array $array, int $startingIndex, $expected )
    {
        // Create IArrayable object instance
        $arrayable = $this->createArrayable( $array );

        // Run test
        $this->assertEquals(
            $expected,
            ( new ArrayableIterator( $arrayable, $startingIndex, 1 ))->getValue(),
            'ArrayableIterator->getValue() did not return the expected value.'
        );
    }

    public function getGetValueReturnValueTestData(): array
    {
        $indexedArray = [ 1, 2, 3 ];
        $mappedArray  = [ "a" => 1, "b" => 2, "c" => 3 ];

        return [

            // Indexed Arrays
            'Indexed Arrayable->toArray(): 0, 1' => [ $indexedArray, 0, 1 ],
            'Indexed Arrayable->toArray(): 1, 1' => [ $indexedArray, 1, 2 ],
            'Indexed Arrayable->toArray(): 1, 1' => [ $indexedArray, 2, 3 ],

            // Mapped Arrays
            'Mapped Arrayable->toArray(): 0, 1' => [ $mappedArray, 0, 1 ],
            'Mapped Arrayable->toArray(): 1, 1' => [ $mappedArray, 1, 2 ],
            'Mapped Arrayable->toArray(): 1, 1' => [ $mappedArray, 2, 3 ]
        ];
    }




    /*******************************************************************************************************************
    *                                                     hasCurrent()
    *******************************************************************************************************************/


    /**
     * Ensure hasCurrent() returns expected result
     * 
     * @dataProvider getHasCurrentTestData
     */
    public function testHasCurrent( array $array, int $startingIndex, bool $expected )
    {
        // Create IArrayable object instance
        $arrayable = $this->createArrayable( $array );

        // Run test
        $this->assertEquals(
            $expected,
            ( new ArrayableIterator( $arrayable, $startingIndex ) )->hasCurrent(),
            'ArrayableIterator->hasCurrent() did not return the expected result.'
        );
    }

    public function getHasCurrentTestData(): array
    {
        $indexedArray = [ 1, 2, 3 ];
        $mappedArray  = [ "a" => 1, "b" => 2, "c" => 3 ];

        return [
            '[]'                => [ [],             0, false ],
            'Indexed Array, -1' => [ $indexedArray, -1, false ],
            'Indexed Array,  0' => [ $indexedArray,  0, true ],
            'Indexed Array,  2' => [ $indexedArray,  2, true ],
            'Indexed Array,  3' => [ $indexedArray,  3, false ],
            'Mapped Array,  -1' => [ $mappedArray,  -1, false ],
            'Mapped Array,   0' => [ $mappedArray,   0, true ],
            'Mapped Array,   2' => [ $mappedArray,   2, true ],
            'Mapped Array,   3' => [ $mappedArray,   3, false ]
        ];
    }




    /*******************************************************************************************************************
    *                                                       UTILITIES
    *******************************************************************************************************************/


    /**
     * Create an ArrayableIterator instance
     * 
     * @param array $array         The return value of IArrayable->toArray()
     * @param int   $startingIndex The starting index
     * @param int   $incrementBy   The amount to increment the index by on every goToNext()
     */
    public function createArrayableIterator(
        array $array,
        int   $startingIndex = 0,
        int   $incrementBy   = 1
    ): ArrayableIterator
    {
        return new ArrayableIterator( $this->createArrayable( $array ), $startingIndex, $incrementBy );
    }


    /**
     * Create an IArrayable instance
     * 
     * @param array $array The return value of toArray()
     * @return IArrayable
     */
    private function createArrayable( array $array ): IArrayable
    {
        $arrayable = $this->createMock( IArrayable::class );
        $arrayable->method( 'toArray' )->willReturn( $array );
        return $arrayable;
    }
}