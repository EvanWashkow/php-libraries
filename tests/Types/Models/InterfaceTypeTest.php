<?php
namespace PHP\Tests\Types\Models;

use PHP\Tests\Types\TypeTestCase;

/**
 * Tests the \PHP\Types\InterfaceType functionality
 */
class InterfaceTypeTest extends TypeTestCase
{


    /***************************************************************************
    *                         InterfaceType->equals()
    ***************************************************************************/


    /**
     * Test InterfaceType->equals()
     * 
     * @dataProvider getEqualsData
     * 
     * @param string $typeName    The type name to test
     * @param mixed  $typeOrValue A Type instance or value
     * @param bool   $expected    The expected result
     **/
    public function testEquals( string $typeName, $typeOrValue, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $this->getTypeLookup()->getByName( $typeName )->equals( $typeOrValue ),
            'InterfaceType->equals() did not return the expected results'
        );
    }


    /**
     * Returns equals() test data
     * 
     * @return array
     */
    public function getEqualsData()
    {
        return [

            // Valid
            'Same interface' => [
                'Iterator', $this->getTypeLookup()->getByName( 'Iterator' ), true
            ],
            'Parent->equals( child interface type )' => [
                'Iterator', $this->getTypeLookup()->getByName( 'SeekableIterator' ), true
            ],
            'Parent->equals( child class type )' => [
                'Iterator', $this->getTypeLookup()->getByName( \PHP\Collections\Collection::class ), true
            ],
            'Parent->equals( child class instance )' => [
                'Iterator', new \PHP\Collections\Dictionary( '*', '*' ), true
            ],

            // Invalid
            'Child->equals( parent interface type )' => [
                'SeekableIterator', $this->getTypeLookup()->getByName( 'Iterator' ), false
            ],
            'Child->equals( other type )' => [
                'SeekableIterator', $this->getTypeLookup()->getByName( 'int' ), false
            ],
            'Child->equals( other type instance )' => [
                'SeekableIterator', 1, false
            ],
        ];
    }




    /***************************************************************************
    *                               InterfaceType->is()
    ***************************************************************************/


    /**
     * Test InterfaceType->is()
     * 
     * @dataProvider getIsData
     * 
     * @param string $typeA    Type name to check
     * @param string $typeB    Type name to compare
     * @param bool   $expected The expected result
     **/
    public function testIs( string $typeA, string $typeB, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $this->getTypeLookup()->getByName( $typeA )->is( $typeB ),
            'InterfaceType->is() did not return the expected results'
        );
    }


    /**
     * Returns equals() test data
     * 
     * @return array
     */
    public function getIsData()
    {
        return [

            // Valid
            'Same interface' => [
                'Iterator', 'Iterator', true
            ],
            'Child->is( parent interface type )' => [
                'SeekableIterator', 'Iterator', true
            ],
            
            // Invalid
            'Parent->is( child interface type )' => [
                'Iterator', 'SeekableIterator', false
            ],
            'Parent->is( child class type )' => [
                'Iterator', \PHP\Collections\Collection::class, false
            ],
            'Child->is( other type )' => [
                'SeekableIterator', 'int', false
            ],
            'Child->is( other type instance )' => [
                'SeekableIterator', 1, false
            ],
        ];
    }
    
    
    
    
    /***************************************************************************
    *                              InterfaceType->isInterface()
    ***************************************************************************/
    
    
    /**
     * Ensure InterfaceType->isInterface() returns true for interface types
     */
    public function testIsInterfaceReturnsTrue()
    {
        $type = $this->getTypeLookup()->getByName( 'ArrayAccess' );
        $this->assertTrue(
            $type->isInterface(),
            'Expected InterfaceType->isInterface() to return true for interface types'
        );
    }
}