<?php
namespace PHP\Tests\Types\Models;

use ArrayAccess;
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
     * @param InterfaceType $type     The interface type instance
     * @param string        $typeName Type name to compare
     * @param bool          $expected The expected result
     **/
    public function testIs( InterfaceType $type, string $typeName, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $type->is( $typeName ),
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
        $typeLookup = $this->getTypeLookup();

        return [
            '->getByName( \Iterator::class )->is( "Iterator" )' => [
                $typeLookup->getByName( \Iterator::class ),
                'Iterator',
                true
            ],
            '->getByName( \SeekableIterator::class )->is( "Iterator" )' => [
                $typeLookup->getByName( \SeekableIterator::class ),
                'Iterator',
                true
            ],
            '->getByName( \Iterator::class )->is( "SeekableIterator" )' => [
                $typeLookup->getByName( \Iterator::class ),
                'SeekableIterator',
                false
            ],
            '->getByName( \Iterator::class )->is( \PHP\Collections\Collection::class )' => [
                $typeLookup->getByName( \Iterator::class ),
                \PHP\Collections\Collection::class,
                false
            ],
            '->getByName( \SeekableIterator::class )->is( "int" )' => [
                $typeLookup->getByName( \SeekableIterator::class ),
                'int',
                false
            ],
            '->getByName( \SeekableIterator::class )->is( 1 )' => [
                $typeLookup->getByName( \SeekableIterator::class ),
                1,
                false
            ]
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
        $type = $this->getTypeLookup()->getByName( ArrayAccess::class );
        $this->assertTrue(
            $type->isInterface(),
            'Expected InterfaceType->isInterface() to return true for interface types'
        );
    }
}