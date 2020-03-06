<?php
namespace PHP\Tests\Types\Models;

use PHP\Tests\Types\TypeTestCase;
use PHP\Types\Models\ClassType;

/**
 * Ensure all ClassTypes have same basic functionality
 */
class ClassTypeTest extends TypeTestCase
{




    /***************************************************************************
    *                        ClassType->equals() by type
    ***************************************************************************/

    /**
     * Test ClassType->equals()
     *
     * @dataProvider getEqualsTypeData
     * @dataProvider getEqualsValueData
     *
     * @param ClassType $type        Class type instance
     * @param mixed     $typeOrValue Class type instance to compare A to
     * @param bool      $expected    The expected result
     */
    public function testEquals( ClassType $type, $typeOrValue, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $type->equals( $typeOrValue ),
            'ClassType->equals() did not return the expected value'
        );
    }

    public function getEqualsTypeData(): array
    {
        $typeLookup = $this->getTypeLookup();

        return [
            '->getByName( \ReflectionClass::class )->equals( \ReflectionObject::class )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                $typeLookup->getByName( \ReflectionObject::class ),
                true
            ],
            '->getByName( \ReflectionClass::class )->equals( \ReflectionClass::class )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                $typeLookup->getByName( \ReflectionClass::class ),
                true
            ],
            '->getByName( \ReflectionClass::class )->equals( "int" )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                $typeLookup->getByName( 'int' ),
                false
            ],
            '->getByName( \ReflectionClass::class )->equals( \ReflectionFunction::class )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                $typeLookup->getByName( \ReflectionFunction::class ),
                false
            ],
            '->getByName( \ReflectionObject::class )->equals( \ReflectionClass::class )' => [
                $typeLookup->getByName( \ReflectionObject::class ),
                $typeLookup->getByName( \ReflectionClass::class ),
                false
            ],
            '->getByName( \ReflectionObject::class )->equals( \Reflector::class )' => [
                $typeLookup->getByName( \ReflectionObject::class ),
                $typeLookup->getByName( \Reflector::class ),
                false
            ]
        ];
    }

    public function getEqualsValueData(): array
    {
        $typeLookup = $this->getTypeLookup();

        return [
            '->getByName( \ReflectionClass::class )->equals( new \ReflectionObject( $this ) )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                new \ReflectionObject( $this ),
                true
            ],
            '->getByName( \ReflectionClass::class )->equals( new \ReflectionClass( $this ) )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                new \ReflectionClass( $this ),
                true
            ],
            '->getByName( \ReflectionClass::class )->equals( 1 )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                1,
                false
            ],
            '->getByName( \ReflectionClass::class )->equals( new \ReflectionFunction( function() {} ) )' => [
                $typeLookup->getByName( \ReflectionClass::class ),
                new \ReflectionFunction( function() {} ),
                false
            ],
            '->getByName( \ReflectionObject::class )->equals( new \ReflectionClass( self::class ) )' => [
                $typeLookup->getByName( \ReflectionObject::class ),
                new \ReflectionClass( self::class ),
                false
            ]
        ];
    }




    /***************************************************************************
    *                           ClassType->getName()
    ***************************************************************************/


    /**
     * Ensure ClassType->getName() returns the class name
     *
     * @dataProvider classNamesProvider
     *
     * @param string $className The class name
     **/
    public function testGetName( string $className )
    {
        $this->assertSame(
            $className,
            $this->getTypeLookup()->getByName( $className )->getName(),
            "TypeLookup->getByName( '{$className}' )->getName() did not return the class name"
        );
    }




    /***************************************************************************
    *                               ClassType->is()
    ***************************************************************************/

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
        return [

            // ClassType
            'ClassType->is( int )' => [
                $this->getTypeLookup()->getByName( \ReflectionClass::class ),
                'int',
                false
            ],
            'ClassType->is( other class )' => [
                $this->getTypeLookup()->getByName( \ReflectionClass::class ),
                \ReflectionFunction::class,
                false
            ],
            'ClassType->is( child class )' => [
                $this->getTypeLookup()->getByName( \ReflectionClass::class ),
                \ReflectionObject::class,
                false
            ],
            'ClassType->is( same class )' => [
                $this->getTypeLookup()->getByName( \ReflectionObject::class ),
                \ReflectionObject::class,
                true
            ],
            'ClassType->is( parent class )' => [
                $this->getTypeLookup()->getByName( \ReflectionObject::class ),
                \ReflectionClass::class,
                true
            ],
            'ClassType->is( parent interface )' => [
                $this->getTypeLookup()->getByName( \ReflectionObject::class ),
                'Reflector',
                true
            ]
        ];
    }



    /***************************************************************************
    *                             ClassType->isClass()
    ***************************************************************************/


    /**
     * Ensure ClassType->isClass() returns true for classes
     *
     * @dataProvider classTypesProvider
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




    /***************************************************************************
    *                            ClassType->isInterface()
    ***************************************************************************/


    /**
     * Ensure ClassType->isInterface() returns false for class types
     *
     * @dataProvider classTypesProvider
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




    /***************************************************************************
    *                                  DATA
    ***************************************************************************/


    /**
     * Retrieve a list of types as a data provider
     *
     * @return ClassType[]
     **/
    public function classTypesProvider(): array
    {
        $types = [];
        foreach ( $this->classNamesProvider() as $array ) {
            $name = $array[ 0 ];
            $types[] = [ $this->getTypeLookup()->getByName( $name ) ];
        }
        return $types;
    }


    /**
     * Provides test name data
     *
     * @return string[]
     **/
    public function classNamesProvider(): array
    {
        return [
            [ \PHP\Collections\Dictionary::class ] // ClassType
        ];
    }
}