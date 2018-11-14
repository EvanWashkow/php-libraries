<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;

/**
 * Tests the \PHP\Types\ClassType functionality
 */
class ClassTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                         ClassType->equals() by Type
    ***************************************************************************/


    /**
     * Ensure ClassType->equals() returns true for the same class type
     **/
    public function testEqualsReturnsTrueForSameClassType()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $this->assertTrue(
            $type->equals( $type ),
            'ClassType->equals() should return true for the same class type'
        );
    }


    /**
     * Ensure ClassType->equals() returns true for a parent class type
     **/
    public function testEqualsReturnsTrueForParentClassType()
    {
        $typeName   = 'PHP\\Collections\\Collection';
        $type       = Types::GetByName( $typeName );
        $parentType = Types::GetByName( 'PHP\\Collections\\Sequence' );
        $this->assertTrue(
            $type->equals( $parentType ),
            'ClassType->equals() should return true for a parent class type'
        );
    }


    /**
     * Ensure ClassType->equals() returns false for a base class type
     **/
    public function testEqualsReturnsBaseForBaseClassType()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $baseType = Types::GetByName( 'PHP\\Collections\\Iterator' );
        $this->assertFalse(
            $type->equals( $baseType ),
            'ClassType->equals() should return false for a base class type'
        );
    }


    /**
     * Ensure ClassType->equals() returns false for a base interface type
     **/
    public function testEqualsReturnsBaseForBaseInterfaceType()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $baseType = Types::GetByName( 'PHP\\Collections\\IIterator' );
        $this->assertFalse(
            $type->equals( $baseType ),
            'ClassType->equals() should return false for a base interface type'
        );
    }




    /***************************************************************************
    *                         ClassType->equals() by value
    ***************************************************************************/


    /**
     * Ensure ClassType->equals() returns true for the same class value
     **/
    public function testEqualsReturnsTrueForSameClassValue()
    {
        $value = new \PHP\Collections\Sequence();
        $type  = Types::GetByValue( $value );
        $this->assertTrue(
            $type->equals( $value ),
            'ClassType->equals() should return true for the same class value'
        );
    }


    /**
     * Ensure ClassType->equals() returns true for a parent class value
     **/
    public function testEqualsReturnsTrueForParentClassValue()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $value    = new \PHP\Collections\Sequence();
        $this->assertTrue(
            $type->equals( $value ),
            'ClassType->equals() should return true for a parent class value'
        );
    }


    /**
     * Ensure ClassType->equals() returns false for a base class value
     **/
    public function testEqualsReturnsFalseForBaseClassValue()
    {
        $value = new \PHP\Collections\Dictionary();
        $type  = Types::GetByName( 'PHP\\Cache' );
        $this->assertFalse(
            $type->equals( $value ),
            'ClassType->equals() should return false for a base class value'
        );
    }




    /***************************************************************************
    *                            ClassType->getName()
    *
    * This was already tested when testing type lookup in TypesTest. Nothing to
    * do here.
    ***************************************************************************/




    /***************************************************************************
    *                               ClassType->is()
    ***************************************************************************/


    /**
     * Ensure InterfaceType->is() returns false for basic types (like integers)
     */
    public function testIsReturnsFalseForBasicTypes()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $this->assertFalse(
            $type->is( 'int' ),
            'InterfaceType->is() should return false for basic types (like integers)'
        );
    }


    /**
     * Ensure ClassType->is() returns true for the same class name
     */
    public function testIsReturnsTrueForSameClass()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $this->assertTrue(
            $type->is( $typeName ),
            'ClassType->is() should return true for the same class name'
        );
    }


    /**
     * Ensure ClassType->is() returns true for a base class name
     */
    public function testIsReturnsTrueForBaseClass()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $this->assertTrue(
            $type->is( 'PHP\\Collections\\Iterator' ),
            'ClassType->is() should return true for a base class name'
        );
    }


    /**
     * Ensure ClassType->is() returns true for a base interface name
     */
    public function testIsReturnsTrueForBaseInterface()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $this->assertTrue(
            $type->is( 'PHP\\Collections\\IIterator' ),
            'ClassType->is() should return true for a base interface name'
        );
    }


    /**
     * Ensure ClassType->is() returns false for a parent class name
     */
    public function testIsReturnsFalseForParentClass()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $this->assertFalse(
            $type->is( 'PHP\\Collections\\Sequence' ),
            'ClassType->is() should return false for a parent class name'
        );
    }


    /**
     * Ensure ClassType->is() returns false for a parent interface name
     */
    public function testIsReturnsFalseForParentInterface()
    {
        $typeName = 'PHP\\Collections\\Collection';
        $type     = Types::GetByName( $typeName );
        $this->assertFalse(
            $type->is( 'PHP\\Collections\\ISequence' ),
            'ClassType->is() should return false for a parent interface name'
        );
    }
    
    
    
    
    /***************************************************************************
    *                             ClassType->isClass()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isClass() returns true for classes
     */
    public function testIsClassReturnsTrue()
    {
        $type = \PHP\Types::GetByName( 'ReflectionClass' );
        $this->assertTrue(
            $type->isClass(),
            'Expected Type->isClass() to return true for classes'
        );
    }
    
    
    
    
    /***************************************************************************
    *                            ClassType->isFunction()
    ***************************************************************************/
    
    
    /**
     * Ensure ClassType->isFunction() returns true for Closure instances
     */
    public function testIsFunctionReturnsTrue()
    {
        $type = \PHP\Types::GetByValue( function() {} );
        $this->assertTrue(
            $type->isFunction(),
            'Expected Type->isFunction() to return true for Closure instances'
        );
    }
    
    
    /**
     * Ensure ClassType->isFunction() returns false for non-Closure instances
     */
    public function testIsFunctionReturnsFalse()
    {
        $type = \PHP\Types::GetByName( 'stdClass' );
        $this->assertFalse(
            $type->isFunction(),
            'Expected Type->isFunction() to return false for non-Closure instances'
        );
    }
    
    
    
    
    /***************************************************************************
    *                              Type->isInterface()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isInterface() returns false for class types
     */
    public function testIsInterfaceReturnsFalse()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertFalse(
            $type->isInterface(),
            'Expected Type->isInterface() to return false for class types'
        );
    }
}