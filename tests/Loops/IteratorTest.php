<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\Iterator;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Iterator definition
 */
class IteratorTest extends TestCase
{


    /**
     * Ensure class implements the \Iterator interface
     */
    public function testIsIteratorInterface()
    {
        $iterator = $this->createMock( Iterator::class );
        $iterator->method( 'rewind' );

        $this->assertInstanceOf(
            \Iterator::class,
            $iterator,
            Iterator::class . ' is not an instance of \\Iterator.'
        );
    }
}