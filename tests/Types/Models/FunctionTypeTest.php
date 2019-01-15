<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;

/**
 * Tests the \PHP\Types\FunctionType functionality
 */
class FunctionTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                          FunctionType->equals()
    ***************************************************************************/


    /**
     * Ensure FunctionType equals its own FunctionType
     **/
    public function testEqualsReturnsTrueForSameFunctionType()
    {
        $type = Types::GetByName( 'substr' );
        $this->assertTrue(
            $type->equals( $type ),
            'FunctionType->equals() should return true for same FunctionType'
        );
    }


    /**
     * Ensure FunctionType does not equal a different Type
     **/
    public function testEqualsReturnsFalseForDifferentType()
    {
        $type      = Types::GetByName( 'substr' );
        $otherType = Types::GetByName( 'int' );
        $this->assertFalse(
            $type->equals( $otherType ),
            'FunctionType->equals() should return false for a different Type'
        );
    }


    /**
     * Ensure FunctionType does not equal a generic FunctionType
     **/
    public function testEqualsReturnsFalseForFunctionType()
    {
        $type      = Types::GetByName( 'substr' );
        $otherType = Types::GetByName( 'function' );
        $this->assertFalse(
            $type->equals( $otherType ),
            'FunctionType->equals() should return false for a generic FunctionType'
        );
    }


    /**
     * Ensure FunctionType does not equal a different FunctionType
     **/
    public function testEqualsReturnsFalseForDifferentFunctionType()
    {
        $type      = Types::GetByName( 'substr' );
        $otherType = Types::GetByName( 'strpos' );
        $this->assertFalse(
            $type->equals( $otherType ),
            'FunctionType->equals() should return false for a different FunctionType'
        );
    }


    /**
     * Ensure FunctionType does not equal any values passed in
     **/
    public function testEqualsReturnsFalseForValues()
    {
        $type = Types::GetByName( 'substr' );
        $this->assertFalse(
            $type->equals( 'substr' ),
            'FunctionType->equals() should return false for any values passed in'
        );
    }




    /***************************************************************************
    *                      FunctionType->getFunctionName()
    ***************************************************************************/


    /**
     * Ensure FunctionType->getFunctionName() returns the function name
     **/
    public function testGetFunctionNameReturnsName()
    {
        $this->assertEquals(
            'substr',
            Types::GetByName( 'substr' )->getFunctionName(),
            'Expected FunctionType->getFunctionName() to return the function name'
        );
    }




    /***************************************************************************
    *                         FunctionType->getNames()
    ***************************************************************************/


    /**
     * Ensure getNames() returns the function name
     **/
    public function testGetNames()
    {
        $functionName = 'substr';
        $type         = Types::GetByName( $functionName );
        $this->assertTrue(
            $type->getNames()->hasValue( $functionName ),
            'Expected FunctionType->getNames() to return "function" and the function name'
        );
    }




    /***************************************************************************
    *                             FunctionType->is()
    ***************************************************************************/


    /**
     * Ensure is() returns true for the function name
     **/
    public function testIsReturnsTrueForTheFunctionName()
    {
        $this->assertTrue(
            Types::GetByName( 'substr' )->is( 'substr' ),
            'FunctionType->is() should return true for the function name'
        );
    }
}