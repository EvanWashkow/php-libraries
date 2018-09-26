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
     * Ensure Type->is() returns true for valid type name
     */
    public function testIsWithValidTypeName()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertTrue(
            $type->is( 'int' ),
            'Expected Type->is() to return true for a valid type name'
        );
    }
    
    
    /**
     * Ensure Type->is() returns true for aliases
     **/
    public function testIsWithValidAlias()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertTrue(
            $type->is( 'integer' ),
            'Expected Type->is() to return true for a valid type alias'
        );
    }
    
    
    /**
     * Ensure Type->is() returns false for invalid type name
     */
    public function testIsWithInvalidTypeName()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertFalse(
            $type->is( 'bool' ),
            'Expected Type->is() to return false for an invalid type name'
        );
    }
    
    
    /**
     * Ensure Type->is() returns false for invalid type alias
     */
    public function testIsWithInvalidAlias()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertFalse(
            $type->is( 'boolean' ),
            'Expected Type->is() to return false for an invalid type alias'
        );
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
