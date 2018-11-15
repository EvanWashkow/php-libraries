<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;
use PHP\Collections\Sequence;
use PHP\Types\Type;


/**
 * Tests the base Type functionality
 */
class TypeTest extends \PHP\Tests\TestCase
{
    
    
    /***************************************************************************
    *                            Type->__construct()
    ***************************************************************************/


    /**
     * Ensure Type->__construct throws an exception on an empty name
     * 
     * @expectedException InvalidArgumentException
     **/
    public function testConstructThrowsExceptionOnEmptyName()
    {
        new Type( '' );
    }




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
            Types::GetByValue( 1 )->equals( 2 ),
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
    *                             Type->getName()
    *
    * This was already tested when testing type lookup in TypesTest. Nothing to
    * do here.
    ***************************************************************************/
    
    
    
    
    /***************************************************************************
    *                             Type->getNames()
    ***************************************************************************/
    
    /**
     * Ensure each type has the correct names
     */
    public function testGetNames()
    {
        $namesMap = [
            
            // Basic types
            'array'     => [ 'array' ],
            'bool'      => [ 'bool', 'boolean' ],
            'int'       => [ 'int', 'integer' ],
            'float'     => [ 'float', 'double' ],
            'null'      => [ 'null' ],
            'string'    => [ 'string' ],
            
            // Other
            'unknown type'  => [ 'unknown type' ],
            Sequence::class => [ Sequence::class ]
        ];
        
        // Ensure each type has the correct names
        foreach ( $namesMap as $typeName => $names ) {
            $type = Types::GetByName( $typeName );
            $this->assertEquals(
                $names,
                $type->getNames()->toArray(),
                "Type->getNames() did not return the correct names"
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
    *                                Type->isClass()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isClass() returns false for basic types
     */
    public function testIsClassReturnsFalse()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertFalse(
            $type->isClass(),
            'Expected Type->isClass() to return false for basic types'
        );
    }
    
    
    
    
    /***************************************************************************
    *                              Type->isCallable()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isCallable() returns false for basic types
     */
    public function testIsFunctionReturnsFalse()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertFalse(
            $type->isCallable(),
            'Expected Type->isCallable() to return false for basic types'
        );
    }
    
    
    
    
    /***************************************************************************
    *                              Type->isInterface()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isInterface() returns false for basic types
     */
    public function testIsInterfaceReturnsFalse()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertFalse(
            $type->isInterface(),
            'Expected Type->isInterface() to return false for basic types'
        );
    }
}
