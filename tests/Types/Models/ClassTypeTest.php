<?php
namespace PHP\Tests\Types\Models;

use PHP\Tests\Types\TypeTestCase;
use PHP\Types\Models\ClassType;
use PHP\Types\Models\Type;

/**
 * Ensure all ClassTypes have same basic functionality
 */
class ClassTypeTest extends TypeTestCase
{


    /***************************************************************************
    *                                 TYPE CHECK
    ***************************************************************************/


    /**
     * Ensure that a type lookup returns a ClassType instance
     * 
     * @dataProvider classNamesProvider
     * 
     * @param string $className The class name
     **/
    public function testTypesLookup( string $className )
    {
        $this->assertInstanceOf(
            ClassType::class,
            $this->getTypeLookup()->getByName( $className ),
            'Types lookup should return a ClassType instance when given a class name'
        );
    }




    /***************************************************************************
    *                            ClassType->getName()
    *
    * This was already tested when testing type lookup in Types Test. Nothing to
    * do here.
    ***************************************************************************/




    /***************************************************************************
    *                        ClassType->equals() by type
    ***************************************************************************/

    /**
     * Test ClassType->equals()
     * 
     * @dataProvider equalsByTypeProvider
     * 
     * @param ClassType $typeA    Class type instance
     * @param Type       $typeB    Class type instance to compare A to
     * @param bool       $expected The expected result
     */
    public function testEqualsByType( ClassType $typeA,
                                      Type      $typeB,
                                      bool      $expected )
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
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                $this->getTypeLookup()->getByName( 'int' ),
                false
            ],
            'ClassType->equals( other class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionClass' ),
                $this->getTypeLookup()->getByName( 'ReflectionFunction' ),
                false
            ],
            'ClassType->equals( child class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionClass' ),
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                true
            ],
            'ClassType->equals( same class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                true
            ],
            'ClassType->equals( parent class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                $this->getTypeLookup()->getByName( 'ReflectionClass' ),
                false
            ],
            'ClassType->equals( parent interface )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                $this->getTypeLookup()->getByName( 'Reflector' ),
                false
            ]
        ];
    }




    /***************************************************************************
    *                        ClassType->equals() by value
    ***************************************************************************/

    /**
     * Test ClassType->equals() by value
     * 
     * @dataProvider equalsByValueProvider
     * 
     * @param ClassType $type     Class type instance
     * @param mixed      $value    Value to compare the type to
     * @param bool       $expected The expected result
     */
    public function testEqualsByValue( ClassType $type, $value, bool $expected )
    {
        $this->assertSame(
            $expected,
            $type->equals( $value )
        );
    }


    /**
     * Data provider for is() test
     *
     * @return array
     **/
    public function equalsByValueProvider(): array
    {
        return [

            // ClassType
            'ClassType->equals( int )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                1,
                false
            ],
            'ClassType->equals( other class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionClass' ),
                new \ReflectionFunction( function() {} ),
                false
            ],
            'ClassType->equals( child class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionClass' ),
                new \ReflectionObject( $this ),
                true
            ],
            'ClassType->equals( same class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                new \ReflectionObject( $this ),
                true
            ],
            'ClassType->equals( parent class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
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
            "$this->getTypeLookup()->getByName( '{$className}' )->getName() did not return the class name"
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
                $this->getTypeLookup()->getByName( 'ReflectionClass' ),
                'int',
                false
            ],
            'ClassType->is( other class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionClass' ),
                'ReflectionFunction',
                false
            ],
            'ClassType->is( child class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionClass' ),
                'ReflectionObject',
                false
            ],
            'ClassType->is( same class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                'ReflectionObject',
                true
            ],
            'ClassType->is( parent class )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
                'ReflectionClass',
                true
            ],
            'ClassType->is( parent interface )' => [
                $this->getTypeLookup()->getByName( 'ReflectionObject' ),
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