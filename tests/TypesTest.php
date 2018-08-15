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
     * Ensure Types::GetByName() returns a `Type` instance
     */
    public function testGetByNameReturnsType()
    {
        foreach ( TypesData::Get() as $data ) {
            if ( array_key_exists( 'name', $data['in'] )) {
                $this->assertInstanceOf(
                    'PHP\\Types\\Type',
                    Types::GetByName( $data['in']['name'] ),
                    'Expected Types::GetByName() to return a PHP\\Types\\Type instance'
                );
            }
            if ( array_key_exists( 'shortName', $data['in'] )) {
                $this->assertInstanceOf(
                    'PHP\\Types\\Type',
                    Types::GetByName( $data['in']['shortName'] ),
                    'Expected Types::GetByName() to return a PHP\\Types\\Type instance'
                );
            }
        }
    }
    
    
    /**
     * Ensure Types::GetByValue() returns a `Type` instance
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
    
    
    /**
     * Ensure all Types::GetBy methods return the same type data
     */
    public function testGetByMethodsReturnSameResults()
    {
        foreach ( TypesData::Get() as $data ) {
            
            // Array to retain all Type instances
            $types = [];
            
            // Create the list of types
            if ( array_key_exists( 'value', $data['in'] )) {
                $types[ 'value' ]     = Types::GetByValue( $data['in']['value'] );
            }
            if ( array_key_exists( 'name', $data['in'] )) {
                $types[ 'name' ]      = Types::GetByName(  $data['in']['name'] );
            }
            if ( array_key_exists( 'shortName', $data['in'] )) {
                $types[ 'shortName' ] = Types::GetByName(  $data['in']['shortName'] );
            }
            
            // For each type instance, ensure it has the same data properties as
            // the others
            $previous = null;
            foreach ( $types as $input => $type ) {
                if ( null !== $previous ) {
                    $this->assertTrue(
                        $previous == $type,
                        "Expected all Types::GetBy methods to return the same type data"
                    );
                }
                $previous = $type;
            }
        }
    }
}
