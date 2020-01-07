<?php
namespace PHP\Tests\Types\Models;

use PHP\Collections\Dictionary;
use PHP\Types;
use PHP\Tests\Types\Models\SampleTypes\SampleInterface;

/**
 * Tests the \PHP\Types\InterfaceType functionality
 */
class InterfaceTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                                getConstants()
    ***************************************************************************/


    /**
     * Test getConstants() returned values
     * 
     * @dataProvider getConstantsData()
     */
    public function testConstants( Dictionary $constants, array $expected )
    {
        $this->assertEquals(
            $expected,
            $constants->toArray(),
            'InterfaceType->getConstants() did not return the same constants as those defined in SampleInterface.'
        );
    }


    public function getConstantsData(): array
    {
        return [
            'SampleInterface' => [
                Types::GetByName( SampleInterface::class )->getConstants(),
                [
                    'PUBLIC_STRING' => SampleInterface::PUBLIC_STRING,
                    'PUBLIC_INT'    => SampleInterface::PUBLIC_INT
                ]
            ]
        ];
    }



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
            Types::GetByName( $typeName )->equals( $typeOrValue ),
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
                'Iterator', Types::GetByName( 'Iterator' ), true
            ],
            'Parent->equals( child interface type )' => [
                'Iterator', Types::GetByName( 'SeekableIterator' ), true
            ],
            'Parent->equals( child class type )' => [
                'Iterator', Types::GetByName( \PHP\Collections\Collection::class ), true
            ],
            'Parent->equals( child class instance )' => [
                'Iterator', new \PHP\Collections\Dictionary( '*', '*' ), true
            ],

            // Invalid
            'Child->equals( parent interface type )' => [
                'SeekableIterator', Types::GetByName( 'Iterator' ), false
            ],
            'Child->equals( other type )' => [
                'SeekableIterator', Types::GetByName( 'int' ), false
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
            Types::GetByName( $typeA )->is( $typeB ),
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
        $type = \PHP\Types::GetByName( 'ArrayAccess' );
        $this->assertTrue(
            $type->isInterface(),
            'Expected InterfaceType->isInterface() to return true for interface types'
        );
    }
}