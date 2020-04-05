<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Iterators\IteratedKeyValue;
use PHP\Collections\KeyValuePair;
use PHPUnit\Framework\TestCase;

/**
 * Tests IteratedKeyValue
 */
class IteratedKeyValueTest extends TestCase
{


    /**
     * Ensure it is a KeyValuePair
     */
    public function testIsKeyValuePair()
    {
        $this->assertInstanceOf(
            KeyValuePair::class,
            new IteratedKeyValue( 'one', 'two' ),
            'IteratedKeyValue is not a KeyValuePair.'
        );
    }
}