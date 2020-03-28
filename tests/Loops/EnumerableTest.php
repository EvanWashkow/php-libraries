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
}