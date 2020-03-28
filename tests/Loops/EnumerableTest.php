<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\Enumerable;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Enumerable definition
 */
class EnumerableTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                     INHERITANCE
    *******************************************************************************************************************/


    /**
     * Ensure class implements the \IteratorAggregate interface
     */
    public function testIsIteratorAggregate()
    {
        $enumerable = $this->createMock( Enumerable::class );
        $this->assertInstanceOf(
            \IteratorAggregate::class,
            $enumerable,
            Enumerable::class . ' is not an instance of \\IteratorAggregate.'
        );
    }




    /*******************************************************************************************************************
    *                                                   foreach() loop test
    *******************************************************************************************************************/


    /**
     * Ensure Enumerable works in a single-level foreach loop
     * 
     * @dataProvider getEnumerables
     */
    public function testSingleLevelForEachLoop( Enumerable $enumerable, array $expected )
    {
        $iterated = [];
        foreach ( $enumerable as $key => $value ) {
            $iterated[ $key ] = $value;
        }

        $this->assertEquals(
            $expected,
            $iterated,
            'Enumerable did not traverse the expected values.'
        );
    }


    /**
     * Ensure Enumerable works in a nested foreach loop structure
     * 
     * @dataProvider getEnumerables
     */
    public function testNestedForEachLoops( Enumerable $enumerable, array $expected )
    {
        // Registers for each loop
        $outerIterated = [];
        $innerIterated = [];

        // Nest the loop structures and add entries to the registers for each loop
        foreach ( $enumerable as $outerKey => $outerValue ) {
            $outerIterated[ $outerKey ] = $outerValue;

            foreach ( $enumerable as $innerKey => $innerValue ) {
                $innerIterated[ $innerKey ] = $innerValue;
            }
        }

        $this->assertEquals(
            $expected,
            $outerIterated,
            'Enumerable did not traverse the expected values in the outer loop.'
        );
        $this->assertEquals(
            $expected,
            $innerIterated,
            'Enumerable did not traverse the expected values in the inner loop.'
        );
    }


    /**
     * Retrieve sample Enumerable test data
     */
    public function getEnumerables(): array
    {
        return [

            'SampleEnumerable' => [
                new SampleEnumerable,
                SampleEnumerable::VALUES
            ]
        ];
    }
}