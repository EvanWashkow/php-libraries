<?php
namespace PHP\Tests\Types\Models;

use PHP\Tests\Types\TypeTestCase;
use PHP\Types\Models\InterfaceType;

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
     * @param InterfaceType $type        The interface type to test
     * @param mixed         $typeOrValue A Type instance or value
     * @param bool          $expected    The expected result
     **/
    public function testEquals( InterfaceType $type, $typeOrValue, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $type->equals( $typeOrValue ),
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
        $typeLookup = $this->getTypeLookup();

        return [
            'Same interface' => [
                $typeLookup->getByName( \Iterator::class ),
                $typeLookup->getByName( \Iterator::class ),
                true
            ],
            'Parent->equals( child interface type )' => [
                $typeLookup->getByName( \Iterator::class ),
                $typeLookup->getByName( \SeekableIterator::class ),
                true
            ],
            'Parent->equals( child class type )' => [
                $typeLookup->getByName( \Iterator::class ),
                $typeLookup->getByName( \PHP\Collections\Collection::class ),
                true
            ],
            'Parent->equals( child class instance )' => [
                $typeLookup->getByName( \Iterator::class ),
                new \PHP\Collections\Dictionary( '*', '*' ),
                true
            ],
            'Child->equals( parent interface type )' => [
                $typeLookup->getByName( \SeekableIterator::class ),
                $typeLookup->getByName( \Iterator::class ),
                false
            ],
            'Child->equals( other type )' => [
                $typeLookup->getByName( \SeekableIterator::class ),
                $typeLookup->getByName( 'int' ),
                false
            ],
            'Child->equals( other type instance )' => [
                $typeLookup->getByName( \SeekableIterator::class ),
                1,
                false
            ]
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