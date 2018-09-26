<?php
namespace PHP\Tests;

use PHP\Types;
use PHP\Collections\Sequence;

require_once( __DIR__ . '/TypesData.php' );

/**
 * Tests the \PHP\Types functionality
 */
class TypesTest extends TestCase
{
    
    
    /***************************************************************************
    *                              Types::GetByName()
    ***************************************************************************/
    
    
    /**
     * Ensure Types::GetByName() returns a `Type` instance
     */
    public function testGetByNameReturnsType()
    {
        $this->assertInstanceOf(
            'PHP\\Types\\Type',
            Types::GetByName( 'foobar' ),
            'Expected Types::GetByName() to return a PHP\\Types\\Type instance'
        );
    }
    
    
    /**
     * Ensure Types::GetByName() returns type with the same name
     */
    public function testGetByNameReturnsCorrectName()
    {
        $typeNameMap = [
            'array'         => 'array',
            'boolean'       => 'bool',
            'integer'       => 'int',
            'function'      => 'function',
            'substr'        => 'function',
            'double'        => 'float',
            'null'          => 'null',
            'NULL'          => 'null',
            'string'        => 'string',
            Sequence::class => Sequence::class,
            
            // Other
            'foobar'        => 'unknown type',
            'unknown type'  => 'unknown type'
        ];
        
        // Ensure each type returns its expected type name
        foreach ( $typeNameMap as $query => $name ) {
            $type = Types::GetByName( $query );
            $this->assertEquals(
                $name,
                $type->getName(),
                "Type->getName() did not return the correct name"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                              Types::GetByValue()
    ***************************************************************************/
    
    
    /**
     * Ensure Types::GetByValue() returns a `Type` instance
     */
    public function testGetByValueReturnsType()
    {
        $this->assertInstanceOf(
            'PHP\\Types\\Type',
            Types::GetByValue( null ),
            'Expected Types::GetByValue() to return a PHP\\Types\\Type instance'
        );
    }
    
    
    /**
     * Ensure Types::GetByValue() returns type with the same name
     */
    public function testGetByValueReturnsCorrectName()
    {
        $valueMap = [
            'array'         => [],
            'bool'          => false,
            'int'           => 1,
            'float'         => 1.0,
            'null'          => null,
            'string'        => 'foobar',
            Sequence::class => new Sequence(),
        ];
        
        // Ensure each type returns its expected type name
        foreach ( $valueMap as $name => $value ) {
            $type = Types::GetByValue( $value );
            $this->assertEquals(
                $name,
                $type->getName(),
                "Type->getName() did not return the correct name"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                                     OTHER
    ***************************************************************************/
    
    
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
