<?php
namespace PHP\Tests\Collections\Dictionary;

use PHP\Types;
use PHP\Collections\Dictionary\DictionaryAnonymousKeyType;

/**
 * Tests DictionaryAnonymousKeyType
 */
class DictionaryAnonymousKeyTypeTest extends \PHPUnit\Framework\TestCase
{


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
        return [
            [ 1,                            true ],
            [ 'string',                     true ],
            [ Types::GetByName( 'int' ),    true ],
            [ Types::GetByName( 'string' ), true ],
            [ 1.5,                          false ],
            [ Types::GetByName( 'float' ),  false ]
        ];
    }


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
}
