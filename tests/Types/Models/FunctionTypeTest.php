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
        $referenceType = Types::GetByName( 'substr' );
        $this->assertTrue(
            $referenceType->equals( $referenceType ),
            'FunctionType->equals() should return true for same FunctionType'
        );
    }


    /**
     * Ensure FunctionType does not equal a different Type
     **/
    public function testEqualsReturnsFalseForDifferentType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'int' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'FunctionType->equals() should return false for a different Type'
        );
    }


    /**
     * Ensure FunctionType does not equal a generic FunctionType
     **/
    public function testEqualsReturnsFalseForFunctionType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'function' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'FunctionType->equals() should return false for a generic FunctionType'
        );
    }


    /**
     * Ensure FunctionType does not equal a different FunctionType
     **/
    public function testEqualsReturnsFalseForDifferentFunctionType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'strpos' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'FunctionType->equals() should return false for a different FunctionType'
        );
    }


    /**
     * Ensure FunctionType does not equal any values passed in
     **/
    public function testEqualsReturnsFalseForValues()
    {
        $referenceType = Types::GetByName( 'substr' );
        $this->assertFalse(
            $referenceType->equals( 'substr' ),
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
     * Ensure getNames() returns 'function' and the function name
     **/
    public function testGetNamesReturnsFunctionAndFunctionName()
    {
        $functionName = 'substr';
        $type         = Types::GetByName( $functionName );
        $this->assertEquals(
            [ 'function', $functionName, 'callable' ],
            $type->getNames()->toArray(),
            'Expected FunctionType->getNames() to return "function" and the function name'
        );
    }




    /***************************************************************************
    *                             FunctionType->is()
    ***************************************************************************/


    /**
     * Ensure is() returns true for "function"
     **/
    public function testIsReturnsTrueForFunction()
    {
        $this->assertTrue(
            Types::GetByName( 'substr' )->is( 'function' ),
            'FunctionType->is() should return true for "function"'
        );
    }


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