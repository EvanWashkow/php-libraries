<?php
namespace PHP\Tests\Types\Models;

use PHP\Collections\ByteArray;
use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTests;
use PHP\Types\Models\Type;
use PHP\Types\TypeLookupSingleton;
use PHP\Types\TypeNames;

/**
 * Tests the base Type functionality
 */
final class TypeTest extends TypeTestDefinition
{




    /*******************************************************************************************************************
    *                                    TypeTestDefinition abstraction implementors
    *******************************************************************************************************************/


    public function getSerializationTestData(): array
    {
        return [
            'name = foo' => [ new Type('foo') ],
            'name = bar' => [ new Type('bar') ],
            'name = foo, alias = lorem, ipsum' => [ new Type('foo', ['lorem', 'ipsum']) ],
            'name = bar, alias = sunday, monday' => [ new Type('bar', ['sunday', 'monday']) ],
        ];
    }




    /*******************************************************************************************************************
    *                                                  Type inheritance
    *******************************************************************************************************************/


    /**
     * Ensure Type is an ObjectClass
     */
    public function testTypeIsObjectClass(): void
    {
        $this->assertInstanceOf(
            ObjectClass::class,
            TypeLookupSingleton::getInstance()->getByName( TypeNames::INT ),
            'Type is not an ObjectClass'
        );
    }




    /*******************************************************************************************************************
     *                                                  IEquatable Tests
     ******************************************************************************************************************/


    /**
     * Retrieves a single instance of IEquatableTests
     *
     * @return IEquatableTests
     */
    private function getIEquatableTestsInstance(): IEquatableTests
    {
        static $iequatableTests = null;
        if (null ===$iequatableTests)
        {
            $iequatableTests = new IEquatableTests($this);
        }
        return $iequatableTests;
    }


    /**
     * Test the Type->equals() method
     *
     * @dataProvider getEqualsData
     *
     * @param Type $type
     * @param $comparee
     * @param bool $expected
     */
    public function testEquals(Type $type, $comparee, bool $expected )
    {
        $this->getIEquatableTestsInstance()->testEquals($type, $comparee, $expected);
    }

    public function getEqualsData(): array
    {
        return [
            'Type(int)->equals(Type(int))' => [
                new Type(TypeNames::INT),
                new Type(TypeNames::INT),
                true
            ],
            'Type(string)->equals(Type(string))' => [
                new Type(TypeNames::STRING),
                new Type(TypeNames::STRING),
                true
            ],
            'Type(null)->equals(Type(null))' => [
                new Type(TypeNames::NULL),
                new Type(TypeNames::NULL),
                true
            ],
            'Type(int)->equals(Type(string))' => [
                new Type(TypeNames::INT),
                new Type(TypeNames::STRING),
                false
            ],
            'Type(int)->equals("int")' => [
                new Type(TypeNames::INT),
                TypeNames::INT,
                false
            ],
            'Type(int)->equals(1)' => [
                new Type(TypeNames::INT),
                1,
                false
            ]
        ];
    }


    /**
     * Tests hash()
     *
     * @dataProvider getHashTestData
     *
     * @param Type $type
     * @param ByteArray $byteArray
     * @param bool $expected
     */
    public function testHash(Type $type, ByteArray $byteArray, bool $expected): void
    {
        $this->getIEquatableTestsInstance()->testHash($type, $byteArray, $expected);
    }

    public function getHashTestData(): array
    {
        return [
            'Type(int)->hash() === ByteArray(int)' => [
                new Type(TypeNames::INT),
                new ByteArray(TypeNames::INT),
                true
            ],
            'Type(string)->hash() === ByteArray(string)' => [
                new Type(TypeNames::STRING),
                new ByteArray(TypeNames::STRING),
                true
            ],
            'Type(int)->hash() === ByteArray(string)' => [
                new Type(TypeNames::INT),
                new ByteArray(TypeNames::STRING),
                false
            ]
        ];
    }


    /**
     * Ensure hash() and equals() are consistent
     *
     * @dataProvider getEqualsAndHashConsistencyTestData
     *
     * @param Type $type1
     * @param Type $type2
     */
    public function testEqualsAndHashConsistency(Type $type1, Type $type2): void
    {
        $this->getIEquatableTestsInstance()->testEqualsAndHashConsistency($type1, $type2);
    }

    public function getEqualsAndHashConsistencyTestData(): array
    {
        return [
            'Type(int), Type(int)' => [
                new Type(TypeNames::INT),
                new Type(TypeNames::INT)
            ],
            'Type(string), Type(string)' => [
                new Type(TypeNames::STRING),
                new Type(TypeNames::STRING)
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                Type->__construct()
    *******************************************************************************************************************/


    /**
     * Ensure Type->__construct throws an exception on an empty name
     **/
    public function testConstructThrowsExceptionOnEmptyName()
    {
        $this->expectException(\DomainException::class);
        new Type( '' );
    }
    
    
    
    
    /*******************************************************************************************************************
    *                                             Type->getName() and getNames()
    *
    * This was already tested when testing type lookup in TypesTest. Nothing to
    * do here.
    *******************************************************************************************************************/
    
    
    
    
    /*******************************************************************************************************************
    *                                                      Type->is()
    *******************************************************************************************************************/


    /**
     * Test Type->is()
     * 
     * @dataProvider getIsData
     * 
     * @param Type   $type     Type to call is() on
     * @param string $typeName Type name to compare to
     * @param bool   $expected The expected result of calling $type->is()
     */
    public function testIs( Type $type, string $typeName, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $type->is( $typeName ),
            'Type->is() did not return the correct value'
        );
    }


    /**
     * Data provider for is() test
     *
     * @return array
     **/
    public function getIsData(): array
    {
        return [
            'getByValue( 1 )->is( "int" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'int',
                true
            ],
            'getByValue( 1 )->is( "integer" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'integer',
                true
            ],
            'getByValue( 1 )->is( "integ" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'integ',
                false
            ],
            'getByValue( 1 )->is( "bool" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'bool',
                false
            ],
            'getByValue( 1 )->is( "boolean" )' => [
                TypeLookupSingleton::getInstance()->getByValue( 1 ),
                'boolean',
                false
            ]
        ];
    }
    
    
    
    
    /*******************************************************************************************************************
    *                                                    Type->isClass()
    *******************************************************************************************************************/
    
    
    /**
     * Ensure Type->isClass() returns false for basic types
     */
    public function testIsClassReturnsFalse()
    {
        $type = TypeLookupSingleton::getInstance()->getByValue( 1 );
        $this->assertFalse(
            $type->isClass(),
            'Expected Type->isClass() to return false for basic types'
        );
    }
    
    
    
    
    /*******************************************************************************************************************
    *                                                 Type->isInterface()
    *******************************************************************************************************************/
    
    
    /**
     * Ensure Type->isInterface() returns false for basic types
     */
    public function testIsInterfaceReturnsFalse()
    {
        $type = TypeLookupSingleton::getInstance()->getByValue( 1 );
        $this->assertFalse(
            $type->isInterface(),
            'Expected Type->isInterface() to return false for basic types'
        );
    }




    /*******************************************************************************************************************
     *                                                Type->isValueOfType()
     ******************************************************************************************************************/


    /**
     * Test Type->isValueOfType()
     *
     * @interal This test is bad, because there is no way to test that this function without duplicating all (or some)
     * of the tests in is(). This should be refactored (using dependency injection?), to not dup tests.
     *
     * @dataProvider getIsValueOfTypeTestData
     *
     * @param Type $type
     * @param $value
     * @param bool $expected
     */
    public function testIsValueOfType(Type $type, $value, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $type->isValueOfType($value),
            'Type->isValueOfType() returned the wrong value.'
        );
    }

    public function getIsValueOfTypeTestData(): array
    {
        return [
            'Type(int)->isValueOfType(1)' => [
                new Type(TypeNames::INT),
                1,
                true
            ],
            'Type(int)->isValueOfType("1")' => [
                new Type(TypeNames::INT),
                '1',
                false
            ],
            'Type(string)->isValueOfType("1")' => [
                new Type(TypeNames::STRING),
                '1',
                true
            ],
            'Type(string)->isValueOfType(1)' => [
                new Type(TypeNames::STRING),
                1,
                false
            ]
        ];
    }
}
