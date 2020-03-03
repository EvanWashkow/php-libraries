<?php
namespace PHP\Tests\Types\Models;

use PHP\Tests\Types\TypeTestCase;
use PHP\Types\Models\Type;

/**
 * Tests the \PHP\Types\FunctionType functionality
 */
class FunctionTypeTest extends TypeTestCase
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
    public function testEqualsForFunctionType( Type $type )
    {
        $this->assertTrue(
            $this->getTypeLookup()->getByName( 'function' )->equals( $type ),
            "FunctionType->equals() should return return true for a Type instance"
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
            "FunctionType->equals() should return false for the different Type instance"
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
            "FunctionType->equals() should return false for a value of a different type"
        );
    }


    /**
     * Ensure FunctionType equals its own FunctionType
     **/
    public function testEqualsReturnsTrueForSameFunctionType()
    {
        $type = $this->getTypeLookup()->getByName( 'substr' );
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
        $type      = $this->getTypeLookup()->getByName( 'substr' );
        $otherType = $this->getTypeLookup()->getByName( 'int' );
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
        $type      = $this->getTypeLookup()->getByName( 'substr' );
        $otherType = $this->getTypeLookup()->getByName( 'function' );
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
        $type      = $this->getTypeLookup()->getByName( 'substr' );
        $otherType = $this->getTypeLookup()->getByName( 'strpos' );
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
        $type = $this->getTypeLookup()->getByName( 'substr' );
        $this->assertFalse(
            $type->equals( 'substr' ),
            'FunctionType->equals() should return false for any values passed in'
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
    *                      FunctionType->getFunctionName()
    ***************************************************************************/


    /**
     * Ensure FunctionType->getFunctionName() returns the function name
     **/
    public function testGetFunctionNameReturnsName()
    {
        $this->assertEquals(
            'substr',
            $this->getTypeLookup()->getByName( 'substr' )->getFunctionName(),
            'Expected FunctionType->getFunctionName() to return the function name'
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
            'FunctionType'         => [ $this->getTypeLookup()->getByName( 'function' ) ],
            'FunctionType' => [ $this->getTypeLookup()->getByName( 'substr' ) ]
        ];
    }
}
