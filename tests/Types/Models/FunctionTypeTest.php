<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;
use PHP\Types\Models\FunctionType;

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
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionType The function base type instance
     */
    public function testEqualsForFunctionType( FunctionType $type )
    {
        $this->assertTrue(
            Types::GetByName( 'function' )->equals( $type ),
            "FunctionType->equals() should return return true for a FunctionType instance"
        );
    }
    
    
    /**
     * Ensure FunctionType->equals() returns false for different Type
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionType The function base type instance
     */
    public function testEqualsForDifferentType( FunctionType $type )
    {
        $this->assertFalse(
            $type->equals( Types::GetByName( 'null' )),
            "FunctionType->equals() should return false for the different Type instance"
        );
    }
    
    
    /**
     * Ensure FunctionType->equals() returns false for a value of a different type
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionType The function base type instance
     */
    public function testEqualsForDifferentValueType( FunctionType $type )
    {
        $this->assertFalse(
            $type->equals( 'function' ),
            "FunctionType->equals() should return false for a value of a different type"
        );
    }




    /***************************************************************************
    *                      FunctionType->getFunctionName()
    ***************************************************************************/


    /**
     * Ensure FunctionType->getFunctionName() returns an empty string
     **/
    public function testGetFunctionNameReturnsEmptyString()
    {
        $this->assertTrue(
            '' === Types::GetByName( 'function' )->getFunctionName(),
            'Expected FunctionType->getFunctionName() to always return an empty string'
        );
    }




    /***************************************************************************
    *                         FunctionType->getNames()
    ***************************************************************************/


    /**
     * Ensure getNames() contains 'function'
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionType $type The type instance to check
     **/
    public function testGetNames( FunctionType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->getNames()->hasValue( 'function' ),
            "{$class} implements a FunctionType, therefore {$class}->getNames() should contain 'function'"
        );
    }




    /***************************************************************************
    *                            FunctionType->is()
    ***************************************************************************/


    /**
     * Ensure all is() returns true for 'function'
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionType $type The type instance to check
     **/
    public function testIs( FunctionType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->is( 'function' ),
            "{$class} implements a FunctionType, therefore {$class}->is( 'function' ) should return true"
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
            'FunctionType' => [ Types::GetByName( 'function' ) ],
            'FunctionInstanceType' =>     [ Types::GetByName( 'substr' ) ]
        ];
    }
}
