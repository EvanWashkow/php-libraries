<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;
use PHP\Types\Models\ClassType;
use PHP\Types\Models\Type;

/**
 * Ensure all ClassTypes have same basic functionality
 */
class ClassTypeTest extends \PHP\Tests\TestCase
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
            Types::GetByName( $className ),
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
            
            // CallableClassType
            'CallableClassType->equals( int )' => [
                Types::GetByName( CallableChild::class ),
                Types::GetByName( 'int' ),
                false
            ],
            'CallableClassType->equals( child class )' => [
                Types::GetByName( CallableParent::class ),
                Types::GetByName( CallableChild::class ),
                true
            ],
            'CallableClassType->equals( same class )' => [
                Types::GetByName( CallableChild::class ),
                Types::GetByName( CallableChild::class ),
                true
            ],
            'CallableClassType->equals( parent class )' => [
                Types::GetByName( CallableChild::class ),
                Types::GetByName( CallableParent::class ),
                false
            ],
            'CallableClassType->equals( parent interface )' => [
                Types::GetByName( CallableChild::class ),
                Types::GetByName( ICallable::class ),
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
                Types::GetByName( 'ReflectionObject' ),
                1,
                false
            ],
            'ClassType->equals( child class )' => [
                Types::GetByName( 'ReflectionClass' ),
                new \ReflectionObject( $this ),
                true
            ],
            'ClassType->equals( same class )' => [
                Types::GetByName( 'ReflectionObject' ),
                new \ReflectionObject( $this ),
                true
            ],
            'ClassType->equals( parent class )' => [
                Types::GetByName( 'ReflectionObject' ),
                new \ReflectionClass( self::class ),
                false
            ],

            // CallableClassType
            'CallableClassType->equals( int )' => [
                Types::GetByName( CallableParent::class ),
                1,
                false
            ],
            'CallableClassType->equals( child class )' => [
                Types::GetByName( CallableParent::class ),
                new CallableChild(),
                true
            ],
            'CallableClassType->equals( same class )' => [
                Types::GetByName( CallableParent::class ),
                new CallableChild(),
                true
            ],
            'CallableClassType->equals( parent class )' => [
                Types::GetByName( CallableChild::class ),
                new CallableParent(),
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
            Types::GetByName( $className )->getName(),
            "Types::GetByName( '{$className}' )->getName() did not return the class name"
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

            // CallableClassType
            'CallableClassType->is( int )' => [
                Types::GetByName( CallableChild::class ),
                'int',
                false
            ],
            'CallableClassType->is( child class )' => [
                Types::GetByName( CallableParent::class ),
                CallableChild::class,
                false
            ],
            'CallableClassType->is( same class )' => [
                Types::GetByName( CallableChild::class ),
                CallableChild::class,
                true
            ],
            'CallableClassType->is( parent class )' => [
                Types::GetByName( CallableChild::class ),
                CallableParent::class,
                true
            ],
            'CallableClassType->is( parent interface )' => [
                Types::GetByName( CallableChild::class ),
                ICallable::class,
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
        $class = self::getClassName( $type );
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
        $class = self::getClassName( $type );
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
            $types[] = [ Types::GetByName( $name ) ];
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
            [ \PHP\Collections\Dictionary::class ], // ClassType
            [ CallableChild::class ]                // CallableClassType
        ];
    }
}


interface ICallable {}
class CallableParent implements ICallable
{
    public function __invoke()
    {
        
    }
}
class CallableChild extends CallableParent {}