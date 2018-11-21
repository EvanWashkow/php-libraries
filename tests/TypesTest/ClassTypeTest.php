<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;
use PHP\Types\Models\IClassType;

/**
 * Tests the \PHP\Types\ClassType functionality
 */
class ClassTypeTest extends \PHP\Tests\TestCase
{


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
}