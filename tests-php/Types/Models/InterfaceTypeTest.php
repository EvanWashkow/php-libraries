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