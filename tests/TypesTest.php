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
            if ( array_key_exists( 'names', $data['in'] )) {
                foreach ( $data['in']['names'] as $name ) {
                    $this->assertInstanceOf(
                        'PHP\\Types\\Type',
                        Types::GetByName( $name ),
                        'Expected Types::GetByName() to return a PHP\\Types\\Type instance'
                    );
                }
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
                $types[] = Types::GetByValue( $data['in']['value'] );
            }
            if ( array_key_exists( 'names', $data['in'] )) {
                foreach ( $data['in']['names'] as $name ) {
                    $types[] = Types::GetByName( $name );
                }
            }
            
            // For each type instance, ensure it has the same data properties as
            // the others
            $previous = null;
            foreach ( $types as $index => $type ) {
                if ( null !== $previous ) {
                    $this->assertEquals(
                        $previous,
                        $type,
                        "Expected all Types::GetBy methods to return the same type data"
                    );
                }
                $previous = $type;
            }
        }
    }
}
