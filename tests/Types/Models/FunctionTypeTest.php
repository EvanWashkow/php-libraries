<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;
use PHP\Types\Models\Type;

/**
 * Tests the \PHP\Types\FunctionType functionality
 */
class FunctionTypeTest extends \PHP\Tests\TestCase
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
            Types::GetByName( 'function' )->equals( $type ),
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
            $type->equals( Types::GetByName( 'null' )),
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
        $class = self::getClassName( $type );
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
        $class = self::getClassName( $type );
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
            Types::GetByName( 'substr' )->getFunctionName(),
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
            'FunctionType'         => [ Types::GetByName( 'function' ) ],
            'FunctionType' => [ Types::GetByName( 'substr' ) ]
        ];
    }
}
