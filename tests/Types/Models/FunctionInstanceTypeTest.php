<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;

/**
 * Tests the \PHP\Types\FunctionInstanceType functionality
 */
class FunctionInstanceTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                          FunctionInstanceType->equals()
    ***************************************************************************/


    /**
     * Ensure FunctionInstanceType equals its own FunctionInstanceType
     **/
    public function testEqualsReturnsTrueForSameFunctionInstanceType()
    {
        $type = Types::GetByName( 'substr' );
        $this->assertTrue(
            $type->equals( $type ),
            'FunctionInstanceType->equals() should return true for same FunctionInstanceType'
        );
    }


    /**
     * Ensure FunctionInstanceType does not equal a different Type
     **/
    public function testEqualsReturnsFalseForDifferentType()
    {
        $type      = Types::GetByName( 'substr' );
        $otherType = Types::GetByName( 'int' );
        $this->assertFalse(
            $type->equals( $otherType ),
            'FunctionInstanceType->equals() should return false for a different Type'
        );
    }


    /**
     * Ensure FunctionInstanceType does not equal a generic FunctionInstanceType
     **/
    public function testEqualsReturnsFalseForFunctionInstanceType()
    {
        $type      = Types::GetByName( 'substr' );
        $otherType = Types::GetByName( 'function' );
        $this->assertFalse(
            $type->equals( $otherType ),
            'FunctionInstanceType->equals() should return false for a generic FunctionInstanceType'
        );
    }


    /**
     * Ensure FunctionInstanceType does not equal a different FunctionInstanceType
     **/
    public function testEqualsReturnsFalseForDifferentFunctionInstanceType()
    {
        $type      = Types::GetByName( 'substr' );
        $otherType = Types::GetByName( 'strpos' );
        $this->assertFalse(
            $type->equals( $otherType ),
            'FunctionInstanceType->equals() should return false for a different FunctionInstanceType'
        );
    }


    /**
     * Ensure FunctionInstanceType does not equal any values passed in
     **/
    public function testEqualsReturnsFalseForValues()
    {
        $type = Types::GetByName( 'substr' );
        $this->assertFalse(
            $type->equals( 'substr' ),
            'FunctionInstanceType->equals() should return false for any values passed in'
        );
    }




    /***************************************************************************
    *                      FunctionInstanceType->getFunctionName()
    ***************************************************************************/


    /**
     * Ensure FunctionInstanceType->getFunctionName() returns the function name
     **/
    public function testGetFunctionNameReturnsName()
    {
        $this->assertEquals(
            'substr',
            Types::GetByName( 'substr' )->getFunctionName(),
            'Expected FunctionInstanceType->getFunctionName() to return the function name'
        );
    }
}