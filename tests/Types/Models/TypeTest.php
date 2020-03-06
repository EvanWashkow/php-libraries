<?php
namespace PHP\Tests\Types\Models;

use PHP\Tests\Types\TypeTestCase;
use PHP\Types\Models\Type;


/**
 * Tests the base Type functionality
 */
class TypeTest extends TypeTestCase
{
    
    
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
            'Valid name' => [
                $this->getTypeLookup()->getByValue( 1 ),
                'int',
                true
            ],
            'Valid alias' =>[
                $this->getTypeLookup()->getByValue( 1 ),
                'integer',
                true
            ],
            'Partial name' => [
                $this->getTypeLookup()->getByValue( 1 ),
                'integ',
                false
            ],
            'Invalid name' => [
                $this->getTypeLookup()->getByValue( 1 ),
                'bool',
                false
            ],
            'Invalid alias' => [
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
