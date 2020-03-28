<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\IIterable;
use PHPUnit\Framework\TestCase;

/**
 * Tests the IIterable definition
 */
class IIterableTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                     INHERITANCE
    *******************************************************************************************************************/


    /**
     * Ensure class implements the \IteratorAggregate interface
     */
    public function testIsIteratorAggregate()
    {
        $iterable = $this->createMock( IIterable::class );
        $this->assertInstanceOf(
            \IteratorAggregate::class,
            $iterable,
            IIterable::class . ' is not an instance of \\IteratorAggregate.'
        );
    }




    /*******************************************************************************************************************
    *                                                   foreach() loop test
    *******************************************************************************************************************/


    /**
     * Ensure IIterable works in a single-level foreach loop
     * 
     * @dataProvider getIIterables
     */
    public function testSingleLevelForEachLoop( IIterable $iterable, array $expected )
    {
        $iterated = [];
        foreach ( $iterable as $key => $value ) {
            $iterated[ $key ] = $value;
        }

        $this->assertEquals(
            $expected,
            $iterated,
            'Single-level foreach() loop did not traverse the expected IIterable values.'
        );
    }


    /**
     * Ensure IIterable works in a nested foreach loop structure
     * 
     * @dataProvider getIIterables
     */
    public function testNestedForEachLoops( IIterable $iterable, array $expected )
    {
        // Registers for each loop
        $outerIterated = [];
        $innerIterated = [];

        // Nest the loop structures and add entries to the registers for each loop
        foreach ( $iterable as $outerKey => $outerValue ) {
            $outerIterated[ $outerKey ] = $outerValue;

            foreach ( $iterable as $innerKey => $innerValue ) {
                $innerIterated[ $innerKey ] = $innerValue;
            }
        }

        $this->assertEquals(
            $expected,
            $outerIterated,
            'Outer foreach() loop did not traverse the expected IIterable values.'
        );
        $this->assertEquals(
            $expected,
            $innerIterated,
            'Inner foreach() loop did not traverse the expected IIterable values.'
        );
    }


    /**
     * Retrieve sample IIterable test data
     */
    public function getIIterables(): array
    {
        return [

            'SampleIterable' => [
                new SampleIterable,
                SampleIterable::VALUES
            ]
        ];
    }
}