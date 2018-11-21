<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;


/**
 * Ensure all IClassTypes have same basic functionality
 */
class IClassTypeTest extends \PHP\Tests\TestCase
{
    
    
    /***************************************************************************
    *                             IClassType->isClass()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isClass() returns true for classes
     */
    public function testIsClassReturnsTrue()
    {
        foreach ( self::getTypes() as $type ) {
            $class = self::getClassName( $type );
            $this->assertTrue(
                $type->isClass(),
                "{$class} implements IClassType: {$class}->isClass() should return true"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                            IClassType->isInterface()
    ***************************************************************************/
    
    
    /**
     * Ensure ClassType->isInterface() returns false for class types
     */
    public function testIsInterfaceReturnsFalse()
    {
        foreach ( self::getTypes() as $type ) {
            $class = self::getClassName( $type );
            $this->assertFalse(
                $type->isInterface(),
                "{$class} implements IClassType: {$class}->isInterface() should return false"
            );
        }
    }




    /***************************************************************************
    *                            LIST OF IClassTypes
    ***************************************************************************/


    /**
     * Retrieve list of IClassTypes
     * 
     * @return Types\Model\Type[]
     **/
    private static function getTypes(): array
    {
        return [
            Types::GetByName( 'ReflectionClass' ) // ClassType
        ];
    }
}
