<?php
namespace PHP\Tests\Types\Models;

use PHP\Tests\Types\TypeTestCase;
use PHP\Types\Models\Type;

/**
 * Tests the \PHP\Types\FunctionInstanceType functionality
 */
class FunctionInstanceTypeTest extends TypeTestCase
{
    
    
    /***************************************************************************
    *                           Type->equals()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->equals() returns true for a Type
     * 
     * @dataProvider typesProvider
     * 
     * @param Type The function base type instance
     */
    public function testEqualsForFunctionInstanceType( Type $type )
    {
        $this->assertTrue(
            $this->getTypeLookup()->getByName( 'function' )->equals( $type ),
            "FunctionInstanceType->equals() should return return true for a Type instance"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns false for different Type
     * 
     * @dataProvider typesProvider
     * 
     * @param Type The function base type instance
     */
    public function testEqualsForDifferentType( Type $type )
    {
        $this->assertFalse(
            $type->equals( $this->getTypeLookup()->getByName( 'null' )),
            "FunctionInstanceType->equals() should return false for the different Type instance"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns false for a value of a different type
     * 
     * @dataProvider typesProvider
     * 
     * @param Type The function base type instance
     */
    public function testEqualsForDifferentValueType( Type $type )
    {
        $this->assertFalse(
            $type->equals( 'function' ),
            "FunctionInstanceType->equals() should return false for a value of a different type"
        );
    }


    /**
     * Ensure FunctionInstanceType equals its own FunctionInstanceType
     **/
    public function testEqualsReturnsTrueForSameFunctionInstanceType()
    {
        $type = $this->getTypeLookup()->getByName( 'substr' );
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
        $type      = $this->getTypeLookup()->getByName( 'substr' );
        $otherType = $this->getTypeLookup()->getByName( 'int' );
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
        $type      = $this->getTypeLookup()->getByName( 'substr' );
        $otherType = $this->getTypeLookup()->getByName( 'function' );
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
        $type      = $this->getTypeLookup()->getByName( 'substr' );
        $otherType = $this->getTypeLookup()->getByName( 'strpos' );
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
        $type = $this->getTypeLookup()->getByName( 'substr' );
        $this->assertFalse(
            $type->equals( 'substr' ),
            'FunctionInstanceType->equals() should return false for any values passed in'
        );
    }




    /***************************************************************************
    *                         Type->getNames()
    ***************************************************************************/


    /**
     * Ensure getNames() contains 'function'
     * 
     * @dataProvider typesProvider
     * 
     * @param Type $type The type instance to check
     **/
    public function testGetNames( Type $type )
    {
        $class = get_class( $type );
        $this->assertTrue(
            $type->getNames()->hasValue( 'function' ),
            "{$class} implements a Type, therefore {$class}->getNames() should contain 'function'"
        );
    }




    /***************************************************************************
    *                            Type->is()
    ***************************************************************************/


    /**
     * Ensure all is() returns true for 'function'
     * 
     * @dataProvider typesProvider
     * 
     * @param Type $type The type instance to check
     **/
    public function testIs( Type $type )
    {
        $class = get_class( $type );
        $this->assertTrue(
            $type->is( 'function' ),
            "{$class} implements a Type, therefore {$class}->is( 'function' ) should return true"
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
            $this->getTypeLookup()->getByName( 'substr' )->getFunctionName(),
            'Expected FunctionInstanceType->getFunctionName() to return the function name'
        );
    }




    /***************************************************************************
    *                                    DATA
    ***************************************************************************/


    /**
     * Provides types for testing
     *
     * @return array
     **/
    public function typesProvider(): array
    {
        return [
            'FunctionInstanceType' => [ $this->getTypeLookup()->getByName( 'function' ) ],
            'FunctionInstanceType' => [ $this->getTypeLookup()->getByName( 'substr' ) ]
        ];
    }
}
