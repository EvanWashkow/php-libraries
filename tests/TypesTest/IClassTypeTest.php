<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;
use PHP\Types\Models\IClassType;

/**
 * Ensure all IClassTypes have same basic functionality
 */
abstract class IClassTypeTest extends \PHP\Tests\TestCase
{
    
    
    /***************************************************************************
    *                             IClassType->isClass()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isClass() returns true for classes
     * 
     * @dataProvider classTypesProvider
     * 
     * @param IClassType $type The class type to check
     */
    public function testIsClass( IClassType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->isClass(),
            "{$class} implements IClassType: {$class}->isClass() should return true"
        );
    }
    
    
    
    
    /***************************************************************************
    *                            IClassType->isInterface()
    ***************************************************************************/
    
    
    /**
     * Ensure ClassType->isInterface() returns false for class types
     * 
     * @dataProvider classTypesProvider
     * 
     * @param IClassType $type The class type to check
     */
    public function testIsInterface( IClassType $type )
    {
        $class = self::getClassName( $type );
        $this->assertFalse(
            $type->isInterface(),
            "{$class} implements IClassType: {$class}->isInterface() should return false"
        );
    }




    /***************************************************************************
    *                                  DATA
    ***************************************************************************/


    /**
     * Retrieve a list of types as a data provider
     * 
     * @return IClassType[]
     **/
    public function classTypesProvider(): array
    {
        return [
            [ Types::GetByName( 'ReflectionClass' ) ]   // ClassType
        ];
    }


    /**
     * Retrieve a ClassType instance of a child class
     * 
     * The class in question should have a parent class and interface,
     * for testing purposes.
     * 
     * @return IClassType
     **/
    abstract protected function getChildClassType(): IClassType;
}
