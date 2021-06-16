<?php
namespace PHP\Tests\Types\Models;

use PHP\Types\Models\ClassType;
use PHP\Types\TypeLookupSingleton;

/**
 * Ensure all ClassTypes have same basic functionality
 */
final class ClassTypeTest extends TypeTestDefinition
{


    public function getSerializationTestData(): array
    {
        return [
            'ClassType(ReflectionObject)' => [
                new ClassType(new \ReflectionClass(\ReflectionObject::class)),
            ],
            'ClassType(ReflectionClass)' => [
                new ClassType(new \ReflectionClass(\ReflectionClass::class)),
            ],
        ];
    }




    /*******************************************************************************************************************
    *                                                   ClassType->is()
    *******************************************************************************************************************/

    /**
     * Test ClassType->is()
     *
     * @dataProvider isProvider
     *
     * @param ClassType $typeA    Class type
     * @param string     $typeB    Class name to compare A to
     * @param bool       $expected The expected result
     */
    public function testIs( ClassType $typeA, string $typeB, bool $expected )
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
        $typeLookup = TypeLookupSingleton::getInstance();

        return [
            '->getByName( \ReflectionObject::class )->is( \ReflectionObject::class )' => [
                $typeLookup->getByName( \ReflectionObject::class ),
                \ReflectionObject::class,
                true
            ],
            '->getByName( \ReflectionObject::class )->is( \ReflectionClass::class )' => [
                $typeLookup->getByName( \ReflectionObject::class ),
                \ReflectionClass::class,
                true
            ],
            '->getByName( \ReflectionObject::class )->is( \Reflector::class )' => [
                $typeLookup->getByName( \ReflectionObject::class ),
                \Reflector::class,
                true
            ],
            '->getByName( \ReflectionClass::class )->is( "int" )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                'int',
                false
            ],
            '->getByName( \ReflectionClass::class )->is( \ReflectionFunction::class )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                \ReflectionFunction::class,
                false
            ],
            '->getByName( \ReflectionClass::class )->is( \ReflectionObject::class )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                \ReflectionObject::class,
                false
            ]
        ];
    }



    /*******************************************************************************************************************
    *                                       ClassType->isClass() and ->isInterface()
    *******************************************************************************************************************/


    /**
     * Ensure ClassType->isClass() returns true for classes
     *
     * @dataProvider getClassTypes
     *
     * @param ClassType $type The class type to check
     */
    public function testIsClass( ClassType $type )
    {
        $class = get_class( $type );
        $this->assertTrue(
            $type->isClass(),
            "{$class} implements ClassType: {$class}->isClass() should return true"
        );
    }


    /**
     * Ensure ClassType->isInterface() returns false for class types
     *
     * @dataProvider getClassTypes
     *
     * @param ClassType $type The class type to check
     */
    public function testIsInterface( ClassType $type )
    {
        $class = get_class( $type );
        $this->assertFalse(
            $type->isInterface(),
            "{$class} implements ClassType: {$class}->isInterface() should return false"
        );
    }




    /*******************************************************************************************************************
    *                                                 SHARED DATA PROVIDERS
    *******************************************************************************************************************/


    /**
     * Retrieve a list of types as a data provider
     *
     * @return ClassType[]
     **/
    public function getClassTypes(): array
    {
        return [
            [ TypeLookupSingleton::getInstance()->getByName( \PHP\Collections\Dictionary::class ) ]
        ];
    }
}