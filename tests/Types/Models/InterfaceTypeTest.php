<?php
namespace PHP\Tests\Types\Models;

use ArrayAccess;
use PHP\Types\Models\InterfaceType;
use PHP\Types\TypeLookupSingleton;
use PHPUnit\Framework\TestCase;

/**
 * Tests the \PHP\Types\InterfaceType functionality
 */
class InterfaceTypeTest extends TestCase
{


    /***************************************************************************
    *                         InterfaceType->equals()
    ***************************************************************************/


    /**
     * Test InterfaceType->equals()
     * 
     * @dataProvider getEqualsData
     * 
     * @param string $interface   The interface name
     * @param mixed  $typeOrValue A Type instance or value
     * @param bool   $expected    The expected result
     **/
    public function testEquals( string $interface, $typeOrValue, bool $expected )
    {
        $type = TypeLookupSingleton::getInstance()->getByName( $interface );
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
        $typeLookup = TypeLookupSingleton::getInstance();

        return [
            'Same interface' => [
                \Iterator::class,
                $typeLookup->getByName( \Iterator::class ),
                true
            ],
            'Parent->equals( child interface type )' => [
                \Iterator::class,
                $typeLookup->getByName( \SeekableIterator::class ),
                true
            ],
            'Parent->equals( child class type )' => [
                \Countable::class,
                $typeLookup->getByName( \PHP\Collections\Collection::class ),
                true
            ],
            'Parent->equals( child class instance )' => [
                \Countable::class,
                new \PHP\Collections\Dictionary( '*', '*' ),
                true
            ],
            'Child->equals( parent interface type )' => [
                \SeekableIterator::class,
                $typeLookup->getByName( \Iterator::class ),
                false
            ],
            'Child->equals( other type )' => [
                \SeekableIterator::class,
                $typeLookup->getByName( 'int' ),
                false
            ],
            'Child->equals( other type instance )' => [
                \SeekableIterator::class,
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
        $typeLookup = TypeLookupSingleton::getInstance();

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
        $type = TypeLookupSingleton::getInstance()->getByName( ArrayAccess::class );
        $this->assertTrue(
            $type->isInterface(),
            'Expected InterfaceType->isInterface() to return true for interface types'
        );
    }
}