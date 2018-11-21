<?php
namespace PHP\Tests\TypesTest;

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
     */
    public function testIsClassReturnsTrue()
    {
        $type  = $this->getChildClassType();
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
     */
    public function testIsInterfaceReturnsFalse()
    {
        $type  = $this->getChildClassType();
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
     * Retrieve a ClassType instance of a child class
     * 
     * The class in question should have a parent class and interface,
     * for testing purposes.
     * 
     * @return IClassType
     **/
    abstract protected function getChildClassType(): IClassType;
}
