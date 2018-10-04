<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;

/**
 * Tests the \PHP\Types\ClassType functionality
 */
class ClassTypeTest extends \PHP\Tests\TestCase
{


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
}