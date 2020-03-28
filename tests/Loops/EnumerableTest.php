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
        foreach ( $enumerable as $key => $value) {
            $iterated[ $key ] = $value;
        }

        $this->assertEquals(
            $expected,
            $iterated,
            'Enumerable did not traverse the expected values.'
        );
    }

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