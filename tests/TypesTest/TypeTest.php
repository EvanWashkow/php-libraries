<?php
namespace PHP\Tests\TypesTest;

require_once( __DIR__ . '/../TypesData.php' );

use PHP\Types;
use PHP\Tests\TypesData;
use PHP\Collections\Sequence;


/**
 * Tests the base Type functionality
 */
class TypeTest extends \PHP\Tests\TestCase
{
    
    
    /***************************************************************************
    *                               Type->equals()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->equals() returns true for same Type
     */
    public function testEqualsReturnsTrueForSameType()
    {
        $this->assertTrue(
            Types::GetByValue( 1 )->equals( Types::GetByName( 'int' )),
            "Expected Type->equals() to return true for the same Type instance"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns true for a value of that type
     */
    public function testEqualsReturnsTrueForSameValueType()
    {
        $this->assertTrue(
            Types::GetByValue( 1 )->equals( 1 ),
            "Expected Type->equals() to return true for a value of that type"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns false for different Type
     */
    public function testEqualsReturnsFalseForDifferentType()
    {
        $this->assertFalse(
            Types::GetByValue( 1 )->equals( Types::GetByName( 'bool' )),
            "Expected Type->equals() to return false for the different Type instance"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns false for a value of a different type
     */
    public function testEqualsReturnsFalseForDifferentValueType()
    {
        $this->assertFalse(
            Types::GetByValue( 1 )->equals( true ),
            "Expected Type->equals() to return false for a value of a different type"
        );
    }
    
    
    
    
    /***************************************************************************
    *                             Type->getAliases()
    ***************************************************************************/
    
    /**
     * Ensure Type->getAliases() returns the correct aliases
     */
    public function testGetAliases()
    {
        $aliasesMap = self::getAliasMap();
        foreach ( $aliasesMap as $typeName => $aliases ) {
            $type = Types::GetByName( $typeName );
            $this->assertEquals(
                $aliases,
                $type->getAliases()->toArray(),
                "Type->getAliases() did not return the correct aliases"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                             Type->getName()
    ***************************************************************************/
    
    /**
     * Ensure Type->getName() returns the correct name
     */
    public function testGetNameReturnsCorrectName()
    {
        foreach ( TypesData::Get() as $data ) {
            $type  = self::getType( $data[ 'in' ] );
            $class = self::getClassName( $type );
            $this->assertEquals(
                $data[ 'out' ][ 'name' ],
                $type->getName(),
                "{$class}->getName() did not return the correct name"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                                 Type->is()
    ***************************************************************************/
    
    /**
     * Ensure Type->is() returns true for the same type
     */
    public function testIsReturnsTrueForOwnType()
    {
        $typeNames = self::getTypeNames();
        foreach ( $typeNames as $typeName ) {
            $type = \PHP\Types::GetByName( $typeName );
            $this->assertTrue(
                $type->is( $typeName ),
                'Type should return true for its own type'
            );
        }
    }
    
    
    /**
     * Ensure Type->is() returns true for aliases
     **/
    public function testIsReturnsTrueForAliases()
    {
        $aliasMap = self::getAliasMap();
        foreach ( $aliasMap as $typeName => $aliasTypeNames ) {
            $type = \PHP\Types::GetByName( $typeName );
            foreach ( $aliasTypeNames as $aliasTypeName ) {
                $this->assertTrue(
                    $type->is( $aliasTypeName ),
                    'Type should return true for its aliases'
                );
            }
        }
    }
    
    
    /**
     * Ensure Type->is() returns false for other type names
     **/
    public function testIsReturnsFalse(Type $var = null)
    {
        $typeNames = self::getTypeNames();
        foreach ( $typeNames as $typeName ) {
            $type = \PHP\Types::GetByName( $typeName );
            foreach ( $typeNames as $otherTypeName ) {
                if ( $typeName !== $otherTypeName ) {
                    $this->assertFalse(
                        $type->is( $otherTypeName ),
                        'Type should return false for other types'
                    );
                }
            }
        }
    }
    
    
    
    
    /***************************************************************************
    *                                    DATA
    ***************************************************************************/
    
    /**
     * Retrieve aliases indexed by type name
     * 
     * @return array
     **/
    private static function getAliasMap(): array
    {
        return [
            
            // Basic types
            'array'     => [],
            'bool'      => [ 'boolean' ],
            'int'       => [ 'integer' ],
            'function'  => [],
            'float'     => [ 'double' ],
            'null'      => [],
            'string'    => [],
            
            // Other
            'unknown type'  => [],
            Sequence::class => []
        ];
    }
    
    
    /**
     * Retrieve a list of type names
     * 
     * @return array
     */
    private static function getTypeNames(): array
    {
        return [
            'array',
            'bool',
            'int',
            'function',
            'float',
            'null',
            'string',
            'unknown type',
            Sequence::class ,
        ];
    }
    
    
    
    
    /***************************************************************************
    *                                  UTILITIES
    ***************************************************************************/
    
    /**
     * Return the Type instance for the given data[ 'in' ] property
     *
     * @param array $dataIn The $data[ 'in' ] property
     * @return \PHP\Types\Type
     */
    private static function getType( array $dataIn ): \PHP\Types\Type
    {
        $type = null;
        if ( array_key_exists( 'value', $dataIn )) {
            $type = Types::GetByValue( $dataIn[ 'value' ] );
        }
        elseif ( !empty( $dataIn[ 'names'] )) {
            $type = Types::GetByName( $dataIn[ 'names' ][ 0 ] );
        }
        else {
            throw new \Exception( 'Malformed Type test data. Type query is missing.' );
        }
        return $type;
    }
}
