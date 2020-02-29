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
            'FunctionInstanceType' => [ Types::GetByName( 'substr' ) ]
        ];
    }
}
