<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;

/**
 * Tests the \PHP\Types\InterfaceType functionality
 */
class InterfaceTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                       InterfaceType->equals() by Type
    ***************************************************************************/


    /**
     * Ensure InterfaceType->equals() returns true for the same interface type
     **/
    public function testEqualsReturnsTrueForSameInterfaceType()
    {
        $typeName = 'PHP\\Collections\\ICollection';
        $type     = Types::GetByName( $typeName );
        $this->assertTrue(
            $type->equals( $type ),
            'InterfaceType->equals() should return true for the same interface type'
        );
    }


    /**
     * Ensure InterfaceType->equals() returns true for a parent interface type
     **/
    public function testEqualsReturnsTrueForParentInterfaceType()
    {
        $typeName   = 'PHP\\Collections\\ICollection';
        $type       = Types::GetByName( $typeName );
        $parentType = Types::GetByName( 'PHP\\Collections\\ISequence' );
        $this->assertTrue(
            $type->equals( $parentType ),
            'InterfaceType->equals() should return true for a parent interface type'
        );
    }


    /**
     * Ensure InterfaceType->equals() returns true for a child class type
     **/
    public function testEqualsReturnsTrueForChildClassType()
    {
        $typeName   = 'PHP\\Collections\\ICollection';
        $type       = Types::GetByName( $typeName );
        $parentType = Types::GetByName( 'PHP\\Collections\\Sequence' );
        $this->assertTrue(
            $type->equals( $parentType ),
            'InterfaceType->equals() should return true for a child class type'
        );
    }


    /**
     * Ensure InterfaceType->equals() returns false for a base interface type
     **/
    public function testEqualsReturnsFalseForBaseInterfaceType()
    {
        $typeName = 'PHP\\Collections\\ICollection';
        $type     = Types::GetByName( $typeName );
        $baseType = Types::GetByName( 'PHP\\Collections\\Iterator' );
        $this->assertFalse(
            $type->equals( $baseType ),
            'InterfaceType->equals() should return false for a base interface type'
        );
    }




    /***************************************************************************
    *                      InterfaceType->equals() by value
    ***************************************************************************/


    /**
     * Ensure InterfaceType->equals() returns true for a parent class value
     **/
    public function testEqualsReturnsTrueForParentClassValue()
    {
        $typeName = 'PHP\\Collections\\ICollection';
        $type     = Types::GetByName( $typeName );
        $value    = new \PHP\Collections\Sequence();
        $this->assertTrue(
            $type->equals( $value ),
            'InterfaceType->equals() should return true for a parent class value'
        );
    }


    /**
     * Ensure InterfaceType->equals() returns false for other values
     **/
    public function testEqualsReturnsFalseForBaseClassValue()
    {
        $value = new \PHP\Collections\Dictionary();
        $type  = Types::GetByName( 'PHP\\Collections\\Sequence' );
        $this->assertFalse(
            $type->equals( $value ),
            'InterfaceType->equals() should return false for other values'
        );
    }




    /***************************************************************************
    *                               InterfaceType->is()
    ***************************************************************************/


    /**
     * Ensure InterfaceType->is() returns false for basic types (like integers)
     */
    public function testIsReturnsFalseForBasicTypes()
    {
        $typeName = 'PHP\\Collections\\ICollection';
        $type     = Types::GetByName( $typeName );
        $this->assertFalse(
            $type->is( 'int' ),
            'InterfaceType->is() should return false for basic types (like integers)'
        );
    }


    /**
     * Ensure InterfaceType->is() returns true for the same interface name
     */
    public function testIsReturnsTrueForSameInterface()
    {
        $typeName = 'PHP\\Collections\\ICollection';
        $type     = Types::GetByName( $typeName );
        $this->assertTrue(
            $type->is( $typeName ),
            'InterfaceType->is() should return true for the same interface name'
        );
    }


    /**
     * Ensure InterfaceType->is() returns true for a base interface name
     */
    public function testIsReturnsTrueForBaseInterface()
    {
        $typeName = 'PHP\\Collections\\ICollection';
        $type     = Types::GetByName( $typeName );
        $this->assertTrue(
            $type->is( 'PHP\\Collections\\IIterator' ),
            'InterfaceType->is() should return true for a base interface name'
        );
    }


    /**
     * Ensure InterfaceType->is() returns false for a parent interface name
     */
    public function testIsReturnsFalseForParentClass()
    {
        $typeName = 'PHP\\Collections\\ICollection';
        $type     = Types::GetByName( $typeName );
        $this->assertFalse(
            $type->is( 'PHP\\Collections\\Sequence' ),
            'InterfaceType->is() should return false for a parent interface name'
        );
    }


    /**
     * Ensure InterfaceType->is() returns false for a parent interface name
     */
    public function testIsReturnsFalseForParentInterface()
    {
        $typeName = 'PHP\\Collections\\ICollection';
        $type     = Types::GetByName( $typeName );
        $this->assertFalse(
            $type->is( 'PHP\\Collections\\ISequence' ),
            'InterfaceType->is() should return false for a parent interface name'
        );
    }
    
    
    
    
    /***************************************************************************
    *                              InterfaceType->isInterface()
    ***************************************************************************/
    
    
    /**
     * Ensure InterfaceType->isInterface() returns true for interface types
     */
    public function testIsInterfaceReturnsTrue()
    {
        $type = \PHP\Types::GetByName( 'ArrayAccess' );
        $this->assertTrue(
            $type->isInterface(),
            'Expected InterfaceType->isInterface() to return true for interface types'
        );
    }
}