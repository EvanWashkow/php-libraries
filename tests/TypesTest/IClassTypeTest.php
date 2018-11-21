<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;
use PHP\Types\Models\IClassType;
use PHP\Types\Models\Type;

/**
 * Ensure all IClassTypes have same basic functionality
 */
class IClassTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                               IClassType->equals()
    ***************************************************************************/

    /**
     * Test Type->equals()
     * 
     * @dataProvider equalsByTypeProvider
     * 
     * @param IClassType $typeA    Class name
     * @param Type       $typeB    Class name to compare A to
     * @param bool       $expected The expected result
     */
    public function testEqualsByType( IClassType $typeA,
                                      Type       $typeB,
                                      bool       $expected )
    {
        $this->assertSame(
            $expected,
            $typeA->equals( $typeB )
        );
    }


    /**
     * Data provider for is() test
     *
     * @return array
     **/
    public function equalsByTypeProvider(): array
    {
        return [

            // ClassType
            'ClassType->equals( int )' => [
                Types::GetByName( 'ReflectionObject' ),
                Types::GetByName( 'int' ),
                false
            ],
            'ClassType->equals( child class )' => [
                Types::GetByName( 'ReflectionClass' ),
                Types::GetByName( 'ReflectionObject' ),
                true
            ],
            'ClassType->equals( same class )' => [
                Types::GetByName( 'ReflectionObject' ),
                Types::GetByName( 'ReflectionObject' ),
                true
            ],
            'ClassType->equals( parent class )' => [
                Types::GetByName( 'ReflectionObject' ),
                Types::GetByName( 'ReflectionClass' ),
                false
            ],
            'ClassType->equals( parent interface )' => [
                Types::GetByName( 'ReflectionObject' ),
                Types::GetByName( 'Reflector' ),
                false
            ],
        ];
    }




    /***************************************************************************
    *                               IClassType->is()
    ***************************************************************************/

    /**
     * Test Type->is()
     * 
     * @dataProvider isProvider
     * 
     * @param IClassType $typeA    Class type
     * @param string     $typeB    Class name to compare A to
     * @param bool       $expected The expected result
     */
    public function testIs( IClassType $typeA, string $typeB, bool $expected )
    {
        $this->assertSame(
            $expected,
            $typeA->is( $typeB )
        );
    }


    /**
     * Data provider for is() test
     *
     * @return array
     **/
    public function isProvider(): array
    {
        return [

            // ClassType
            'ClassType->is( int )' => [
                Types::GetByName( 'ReflectionObject' ),
                'int',
                false
            ],
            'ClassType->is( child class )' => [
                Types::GetByName( 'ReflectionClass' ),
                'ReflectionObject',
                false
            ],
            'ClassType->is( same class )' => [
                Types::GetByName( 'ReflectionObject' ),
                'ReflectionObject',
                true
            ],
            'ClassType->is( parent class )' => [
                Types::GetByName( 'ReflectionObject' ),
                'ReflectionClass',
                true
            ],
            'ClassType->is( parent interface )' => [
                Types::GetByName( 'ReflectionObject' ),
                'Reflector',
                true
            ],
        ];
    }



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
}
