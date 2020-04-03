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
     * Test getKey() return value
     * 
     * @dataProvider getKeys
     */
    public function testGetKey( $key )
    {
        $this->assertEquals(
            $key,
            ( new KeyValuePair( $key, 0 ) )->getKey(),
            'KeyValuePair->getKey() did not return the original key.'
        );
    }

    public function getKeys(): array
    {
        return [
            '1'    => [ 1 ],
            '"1"'  => [ '1' ],
            'true' => [ true ]
        ];
    }
}