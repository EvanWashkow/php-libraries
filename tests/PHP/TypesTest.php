<?php
namespace PHP\Tests;

use PHP\Types;

require_once( __DIR__ . '/TypesData.php' );

/**
 * Tests the \PHP\Types functionality
 */
class TypesTest extends TestCase
{
    
    /**
     * Ensure ::GetByValue() returns a `Type` instance
     */
    public function testGetByValueReturnsType()
    {
        foreach ( TypesData::Get() as $data ) {
            if ( array_key_exists( 'value', $data['in'] )) {
                $this->assertInstanceOf(
                    'PHP\\Types\\Type',
                    Types::GetByValue( $data['in']['value'] ),
                    'Expected Types::GetByValue() to return a PHP\\Types\\Type instance'
                );
            }
        }
    }
}
