<?php
namespace PHP\Tests\Collections\Dictionary;

use PHP\Collections\Dictionary\DictionaryAnonymousKeyType;
use PHP\Types\TypeLookupSingleton;

/**
 * Tests DictionaryAnonymousKeyType
 */
class DictionaryAnonymousKeyTypeTest extends \PHPUnit\Framework\TestCase
{

    /***************************************************************************
    *                                   equals()
    ***************************************************************************/


    /**
     * Ensure equals() only returns true for ints and strings
     * 
     * @dataProvider getEqualsData
     * 
     * @param mixed $value    The value to test
     * @param bool  $expected The expected result
     **/
    public function testEquals( $value, bool $expected )
    {
        $this->assertEquals(
            $expected,
            ( new DictionaryAnonymousKeyType() )->equals( $value ),
            'DictionaryAnonymousKeyType->equals() should only returns true for ints and strings'
        );
    }


    /**
     * Get data for testing equals()
     * 
     * @return array
     */
    public function getEqualsData(): array
    {
        $typeLookup = TypeLookupSingleton::getInstance();
        return [
            [ 1,                            true ],
            [ 'string',                     true ],
            [ $typeLookup->getByName( 'int' ),    true ],
            [ $typeLookup->getByName( 'string' ), true ],
            [ 1.5,                          false ],
            [ $typeLookup->getByName( 'float' ),  false ]
        ];
    }




    /***************************************************************************
    *                                     is()
    ***************************************************************************/


    /**
     * Ensure is() only returns true for ints and strings
     * 
     * @dataProvider getIsData
     * 
     * @param string $typeName The type name to test
     * @param bool   $expected The expected result
     **/
    public function testIs( $value, bool $expected )
    {
        $this->assertEquals(
            $expected,
            ( new DictionaryAnonymousKeyType() )->is( $value ),
            'DictionaryAnonymousKeyType->is() should only returns true for ints and strings'
        );
    }


    /**
     * Get data for testing is()
     * 
     * @return array
     */
    public function getIsData(): array
    {
        return [
            [ 'int',    true ],
            [ 'string', true ],
            [ 'float',  false ]
        ];
    }




    /***************************************************************************
    *                                  isClass()
    ***************************************************************************/


    /**
     * Ensure isClass() only returns false
     **/
    public function testIsClass()
    {
        $this->assertFalse(
            ( new DictionaryAnonymousKeyType() )->isClass(),
            'DictionaryAnonymousKeyType->isClass() should only return false'
        );
    }




    /***************************************************************************
    *                                 isInterface()
    ***************************************************************************/


    /**
     * Ensure isInterface() only returns false
     **/
    public function testIsInterface()
    {
        $this->assertFalse(
            ( new DictionaryAnonymousKeyType() )->isInterface(),
            'DictionaryAnonymousKeyType->isInterface() should only return false'
        );
    }
}
