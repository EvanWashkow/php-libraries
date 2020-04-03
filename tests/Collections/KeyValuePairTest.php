<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections;

use PHP\Collections\KeyValuePair;
use PHPUnit\Framework\TestCase;

/**
 * Tests for KeyValuePoir
 */
class KeyValuePairTest extends TestCase
{


    /**
     * Test __construct() throws \InvalidArgumentException on null keys
     */
    public function testConstructThrowsInvalidArgumentExceptionOnNullKey()
    {
        $this->expectException( \InvalidArgumentException::class );
        new KeyValuePair( null, 1 );
    }


    /**
     * Test getKey() return value
     * 
     * @dataProvider getTestKeyValueData
     */
    public function testGetKey( $key )
    {
        $this->assertEquals(
            $key,
            ( new KeyValuePair( $key, 0 ) )->getKey(),
            'KeyValuePair->getKey() did not return the original key.'
        );
    }


    /**
     * Test getValue() return value
     * 
     * @dataProvider getTestKeyValueData
     */
    public function testGetValue( $value )
    {
        $this->assertEquals(
            $value,
            ( new KeyValuePair( 0, $value ) )->getValue(),
            'KeyValuePair->getValue() did not return the original value.'
        );
    }


    /**
     * Data provider for getKey() and getValue() tests
     */
    public function getTestKeyValueData(): array
    {
        return [
            '1'    => [ 1 ],
            '"1"'  => [ '1' ],
            'true' => [ true ]
        ];
    }
}