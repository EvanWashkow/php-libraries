<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\Enumerator;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Enumerator definition
 */
class EnumeratorTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                     INHERITANCE
    *******************************************************************************************************************/


    /**
     * Ensure class implements the \Enumerator interface
     */
    public function testIsEnumeratorInterface()
    {
        $enumerator = $this->createMock( Enumerator::class );
        $this->assertInstanceOf(
            \Iterator::class,
            $enumerator,
            Enumerator::class . ' is not an instance of \\Iterator.'
        );
    }




    /*******************************************************************************************************************
    *                                                       current()
    *******************************************************************************************************************/


    /**
     * Ensure current() returns the expected value
     * 
     * @dataProvider getCurrentReturnValues
     */
    public function testCurrentReturnValue( Enumerator $enumerator, $expected )
    {
        $this->assertEquals(
            $expected,
            $enumerator->current(),
            'Enumerator->current() returned the wrong value.'
        );
    }

    public function getCurrentReturnValues(): array
    {
        return [

            'getValue() === 1' => [
                (function() {
                    $mock = $this->createMock( Enumerator::class );
                    $mock->method( 'hasCurrent' )->willReturn( true );
                    $mock->method( 'getValue' )->willReturn( 1 );
                    return $mock;
                })(),
                1
            ],

            'getValue() === 2' => [
                (function() {
                    $mock = $this->createMock( Enumerator::class );
                    $mock->method( 'hasCurrent' )->willReturn( true );
                    $mock->method( 'getValue' )->willReturn( 2 );
                    return $mock;
                })(),
                2
            ],

            'hasCurrent() === false' => [
                (function() {
                    $mock = $this->createMock( Enumerator::class );
                    $mock->method( 'hasCurrent' )->willReturn( false );
                    $mock->method( 'getValue' )->willThrowException(
                        new \OutOfBoundsException( 'Key does not exist at this position.' )
                    );
                    return $mock;
                })(),
                null
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                         key()
    *******************************************************************************************************************/


    /**
     * Ensure key() returns the expected value
     * 
     * @dataProvider getKeyReturnValues
     */
    public function testKeyReturnValue( Enumerator $enumerator, $expected )
    {
        $this->assertEquals(
            $expected,
            $enumerator->key(),
            'Enumerator->key() returned the wrong value.'
        );
    }

    public function getKeyReturnValues(): array
    {
        return [

            'getKey() === 1' => [
                (function() {
                    $mock = $this->createMock( Enumerator::class );
                    $mock->method( 'hasCurrent' )->willReturn( true );
                    $mock->method( 'getKey' )->willReturn( 1 );
                    return $mock;
                })(),
                1
            ],

            'getKey() === 2' => [
                (function() {
                    $mock = $this->createMock( Enumerator::class );
                    $mock->method( 'hasCurrent' )->willReturn( true );
                    $mock->method( 'getKey' )->willReturn( 2 );
                    return $mock;
                })(),
                2
            ],

            'hasCurrent() === false' => [
                (function() {
                    $mock = $this->createMock( Enumerator::class );
                    $mock->method( 'hasCurrent' )->willReturn( false );
                    $mock->method( 'getKey' )->willThrowException(
                        new \OutOfBoundsException( 'Key does not exist at this position.' )
                    );
                    return $mock;
                })(),
                null
            ]
        ];
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
        $mock = $this->createMock( Enumerator::class );
        $mock->method( 'goToNext' )->willReturnCallback( function() use ( &$isRun ) {
            $isRun = true;
        });
        $mock->next();

        $this->assertTrue(
            $isRun,
            'Enumerator->next() did not call goToNext().'
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
    public function testValid( Enumerator $enumerator )
    {
        $this->assertTrue(
            $enumerator->hasCurrent() === $enumerator->valid(),
            'Enumerator->valid() and Enumerator->hasCurrent() should return the same result.'
        );
    }

    public function getValidTestData(): array
    {
        return [

            'hasCurrent() === true'  => [
                (function() {
                    $mock = $this->createMock( Enumerator::class );
                    $mock->method( 'hasCurrent' )->willReturn( true );
                    return $mock;
                })()
            ],

            'hasCurrent() === false' => [
                (function() {
                    $mock = $this->createMock( Enumerator::class );
                    $mock->method( 'hasCurrent' )->willReturn( false );
                    return $mock;
                })()
            ]
        ];
    }
}