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
     * Ensure getValue() throws \OutOfBoundsException
     * 
     * @dataProvider getGetValueExceptionTestData
     */
    public function testGetValueException( array $array, int $startingIndex )
    {
        // Create IArrayable object instance
        $arrayable = $this->createArrayable( $array );

        // Run test
        $this->expectException( \OutOfBoundsException::class );
        ( new ArrayableIterator( $arrayable, $startingIndex ) )->getValue();
    }

    public function getGetValueExceptionTestData(): array
    {
        return [
            '[]'           => [ [],          0 ],
            '[ 1, 2, 3 ]'  => [ [ 1, 2, 3 ], 3 ],
            '[ 1, 2, 3 ]'  => [ [ 1, 2, 3 ], -1 ],
            "[ 'a' => 1 ]" => [ [ 'a' => 1 ], 1 ]
        ];
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
        return [
            '[]'           => [ [],           0, false ],
            '[ 1, 2, 3 ]'  => [ [ 1, 2, 3 ], -1, false ],
            '[ 1, 2, 3 ]'  => [ [ 1, 2, 3 ],  0, true ],
            '[ 1, 2, 3 ]'  => [ [ 1, 2, 3 ],  2, true ],
            '[ 1, 2, 3 ]'  => [ [ 1, 2, 3 ],  3, false ],
            "[ 'a' => 1 ]" => [ [ 'a' => 1 ], 0, true ],
            "[ 'a' => 1 ]" => [ [ 'a' => 1 ], 1, false ]
        ];
    }




    /*******************************************************************************************************************
    *                                                       UTILITIES
    *******************************************************************************************************************/


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