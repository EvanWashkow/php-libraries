<?php
namespace PHP\Tests\Types\Models;

use PHP\ObjectClass;
use PHP\Tests\Types\TypeTestCase;
use PHP\Types\Models\Type;
use PHP\Types\TypeNames;

/**
 * Tests the base Type functionality
 */
class TypeTest extends TypeTestCase
{




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
            $this->getTypeLookup()->getByName( TypeNames::INT ),
            'Type is not an ObjectClass'
        );
    }




    /*******************************************************************************************************************
    *                                                Type->__construct()
    *******************************************************************************************************************/


    /**
     * Ensure Type->__construct throws an exception on an empty name
     * 
     * @expectedException \DomainException
     **/
    public function testConstructThrowsExceptionOnEmptyName()
    {
        new Type( '' );
    }




    /*******************************************************************************************************************
    *                                                  Type->equals()
    *******************************************************************************************************************/


    /**
     * Test the Type->equals() method
     * 
     * @dataProvider getEqualsData
     */
    public function testEquals( Type $type, $value, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $type->equals( $value ),
            'Type->equals() did not return the correct result'
        );
    }


    public function getEqualsData(): array
    {
        return [

            // Integer
            'getByValue(1)->equals( getByName("int") )' => [
                $this->getTypeLookup()->getByValue( 1 ),
                $this->getTypeLookup()->getByName( 'int' ),
                true
            ],
            'getByValue(1)->equals( 2 )' => [
                $this->getTypeLookup()->getByValue( 1 ),
                2,
                true
            ],
            'getByValue(1)->equals( "1" )' => [
                $this->getTypeLookup()->getByValue( 1 ),
                "1",
                false
            ],
            'getByValue(1)->equals( getByName("bool") )' => [
                $this->getTypeLookup()->getByValue( 1 ),
                $this->getTypeLookup()->getByName( 'bool' ),
                false
            ],
            'getByValue(1)->equals( true )' => [
                $this->getTypeLookup()->getByValue( 1 ),
                true,
                false
            ],

            // Strings
            'getByValue( "1" )->equals( getByName("string") )' => [
                $this->getTypeLookup()->getByValue( '1' ),
                $this->getTypeLookup()->getByName( 'string' ),
                true
            ],
            'getByValue( "1" )->equals( "2" )' => [
                $this->getTypeLookup()->getByValue( '1' ),
                "2",
                true
            ],
            'getByValue( "1" )->equals( 1 )' => [
                $this->getTypeLookup()->getByValue( '1' ),
                1,
                false
            ],
            'getByValue( "1" )->equals( getByName( "bool" ) )' => [
                $this->getTypeLookup()->getByValue( '1' ),
                $this->getTypeLookup()->getByName( 'bool' ),
                false
            ],
            'getByValue( "1" )->equals( true )' => [
                $this->getTypeLookup()->getByValue( '1' ),
                true,
                false
            ],

            // Booleans
            'getByValue( true )->equals( getByName("bool") )' => [
                $this->getTypeLookup()->getByValue( true ),
                $this->getTypeLookup()->getByName( 'bool' ),
                true
            ],
            'getByValue( true )->equals( false )' => [
                $this->getTypeLookup()->getByValue( true ),
                false,
                true
            ],
            'getByValue( true )->equals( 1 )' => [
                $this->getTypeLookup()->getByValue( true ),
                1,
                false
            ]
        ];
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
                $this->getTypeLookup()->getByValue( 1 ),
                'int',
                true
            ],
            'getByValue( 1 )->is( "integer" )' => [
                $this->getTypeLookup()->getByValue( 1 ),
                'integer',
                true
            ],
            'getByValue( 1 )->is( "integ" )' => [
                $this->getTypeLookup()->getByValue( 1 ),
                'integ',
                false
            ],
            'getByValue( 1 )->is( "bool" )' => [
                $this->getTypeLookup()->getByValue( 1 ),
                'bool',
                false
            ],
            'getByValue( 1 )->is( "boolean" )' => [
                $this->getTypeLookup()->getByValue( 1 ),
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
        $type = $this->getTypeLookup()->getByValue( 1 );
        $this->assertFalse(
            $type->isClass(),
            'Expected Type->isClass() to return false for basic types'
        );
    }
    
    
    
    
    /*******************************************************************************************************************
    *                              Type->isInterface()
    *******************************************************************************************************************/
    
    
    /**
     * Ensure Type->isInterface() returns false for basic types
     */
    public function testIsInterfaceReturnsFalse()
    {
        $type = $this->getTypeLookup()->getByValue( 1 );
        $this->assertFalse(
            $type->isInterface(),
            'Expected Type->isInterface() to return false for basic types'
        );
    }
}
