<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;
use PHP\Collections\Sequence;
use PHP\Types\Models\Type;


/**
 * Tests the base Type functionality
 */
class TypeTest extends \PHP\Tests\TestCase
{
    
    
    /***************************************************************************
    *                            Type->__construct()
    ***************************************************************************/


    /**
     * Ensure Type->__construct throws an exception on an empty name
     * 
     * @expectedException InvalidArgumentException
     **/
    public function testConstructThrowsExceptionOnEmptyName()
    {
        new Type( '' );
    }




    /***************************************************************************
    *                               Type->equals()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->equals() returns true for same Type
     */
    public function testEqualsReturnsTrueForSameType()
    {
        $this->assertTrue(
            Types::GetByValue( 1 )->equals( Types::GetByName( 'int' )),
            "Expected Type->equals() to return true for the same Type instance"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns true for a value of that type
     */
    public function testEqualsReturnsTrueForSameValueType()
    {
        $this->assertTrue(
            Types::GetByValue( 1 )->equals( 2 ),
            "Expected Type->equals() to return true for a value of that type"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns false for different Type
     */
    public function testEqualsReturnsFalseForDifferentType()
    {
        $this->assertFalse(
            Types::GetByValue( 1 )->equals( Types::GetByName( 'bool' )),
            "Expected Type->equals() to return false for the different Type instance"
        );
    }
    
    
    /**
     * Ensure Type->equals() returns false for a value of a different type
     */
    public function testEqualsReturnsFalseForDifferentValueType()
    {
        $this->assertFalse(
            Types::GetByValue( 1 )->equals( true ),
            "Expected Type->equals() to return false for a value of a different type"
        );
    }
    
    
    
    
    /***************************************************************************
    *                             Type->getName()
    *
    * This was already tested when testing type lookup in TypesTest. Nothing to
    * do here.
    ***************************************************************************/
    
    
    
    
    /***************************************************************************
    *                             Type->getNames()
    ***************************************************************************/
    
    /**
     * Ensure each type has the correct names
     */
    public function testGetNames()
    {
        $namesMap = [
            
            // Basic types
            'array'     => [ 'array' ],
            'bool'      => [ 'bool', 'boolean' ],
            'int'       => [ 'int', 'integer' ],
            'float'     => [ 'float', 'double' ],
            'null'      => [ 'null' ],
            'string'    => [ 'string' ],
            
            // Other
            'unknown type'  => [ 'unknown type' ],
            Sequence::class => [ Sequence::class ]
        ];
        
        // Ensure each type has the correct names
        foreach ( $namesMap as $typeName => $names ) {
            $type = Types::GetByName( $typeName );
            $this->assertEquals(
                $names,
                $type->getNames()->toArray(),
                "Type->getNames() did not return the correct names"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                                 Type->is()
    ***************************************************************************/


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
                \PHP\Types::GetByValue( 1 ),
                'int',
                true
            ],
            'Valid alias' =>[
                \PHP\Types::GetByValue( 1 ),
                'integer',
                true
            ],
            'Partial name' => [
                \PHP\Types::GetByValue( 1 ),
                'integ',
                false
            ],
            'Invalid name' => [
                \PHP\Types::GetByValue( 1 ),
                'bool',
                false
            ],
            'Invalid alias' => [
                \PHP\Types::GetByValue( 1 ),
                'boolean',
                false
            ]
        ];
    }
    
    
    
    
    /***************************************************************************
    *                                Type->isClass()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isClass() returns false for basic types
     */
    public function testIsClassReturnsFalse()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertFalse(
            $type->isClass(),
            'Expected Type->isClass() to return false for basic types'
        );
    }
    
    
    
    
    /***************************************************************************
    *                              Type->isInterface()
    ***************************************************************************/
    
    
    /**
     * Ensure Type->isInterface() returns false for basic types
     */
    public function testIsInterfaceReturnsFalse()
    {
        $type = \PHP\Types::GetByValue( 1 );
        $this->assertFalse(
            $type->isInterface(),
            'Expected Type->isInterface() to return false for basic types'
        );
    }
}
