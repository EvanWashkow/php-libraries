<?php
namespace PHP\Tests\TypesTest;

require_once( __DIR__ . '/../TypesData.php' );

use PHP\Types;

/**
 * Tests the \PHP\Types\FunctionType functionality
 */
class FunctionTypeTest extends \PHP\Tests\TestCase
{
    
    
    /***************************************************************************
    *                           FunctionType->equals()
    ***************************************************************************/
    
    
    /**
     * Ensure FunctionType->equals() returns true for a FunctionType
     */
    public function testEqualsReturnsTrueForFunctionType()
    {
        $this->assertTrue(
            Types::GetByName( 'function' )->equals( Types::GetByName( 'function' )),
            "Expected FunctionType->equals() to return true for a FunctionType instance"
        );
    }
    
    /**
     * Ensure FunctionType->equals() returns true for a FunctionReferenceType
     */
    public function testEqualsReturnsTrueForFunctionReferenceType()
    {
        $this->assertTrue(
            Types::GetByName( 'function' )->equals( Types::GetByName( 'substr' )),
            "Expected FunctionType->equals() to return true for a FunctionReferenceType"
        );
    }
    
    
    /**
     * Ensure FunctionType->equals() returns false for different Type
     */
    public function testEqualsReturnsFalseForDifferentType()
    {
        $this->assertFalse(
            Types::GetByName( 'function' )->equals( Types::GetByName( 'null' )),
            "Expected FunctionType->equals() to return false for the different Type instance"
        );
    }
    
    
    /**
     * Ensure FunctionType->equals() returns false for a value of a different type
     */
    public function testEqualsReturnsFalseForDifferentValueType()
    {
        $this->assertFalse(
            Types::GetByName( 'function' )->equals( 'function' ),
            "Expected FunctionType->equals() to return false for a value of a different type"
        );
    }
}
