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




    /*******************************************************************************************************************
    *                                                     INHERITANCE
    *******************************************************************************************************************/


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




    /*******************************************************************************************************************
    *                                                         next()
    *******************************************************************************************************************/


    /**
     * Ensure next() forwards the call to goToNext()
     */
    public function testNext()
    {
        $isRun = false;
        $mock = $this->createMock( Iterator::class );
        $mock->method( 'goToNext' )->willReturnCallback( function() use ( &$isRun ) {
            $isRun = true;
        });
        $mock->next();

        $this->assertTrue(
            $isRun,
            'Iterator->next() did not call goToNext().'
        );
    }




    /*******************************************************************************************************************
    *                                                        valid()
    *******************************************************************************************************************/


    /**
     * Ensure valid() reflects hasCurrent()
     * 
     * @dataProvider getValidTestData
     */
    public function testValid( Iterator $iterator )
    {
        $this->assertTrue(
            $iterator->hasCurrent() === $iterator->valid(),
            'Iterator->valid() and Iterator->hasCurrent() should return the same result.'
        );
    }

    public function getValidTestData(): array
    {
        // hasCurrent() returns "true"
        $returnsTrue = $this->createMock( Iterator::class );
        $returnsTrue->method( 'hasCurrent' )->willReturn( true );

        // hasCurrent() returns "false"
        $returnsFalse = $this->createMock( Iterator::class );
        $returnsFalse->method( 'hasCurrent' )->willReturn( false );

        return [
            'hasCurrent() returns true'  => [ $returnsTrue ],
            'hasCurrent() returns false' => [ $returnsFalse ]
        ];
    }
}