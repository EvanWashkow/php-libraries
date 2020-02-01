<?php
namespace PHP\Tests;

use PHP\Collections\Sequence;
use PHPUnit\Framework\TestCase;
use TypeLookup;

/**
 * Test TypeLookup class
 */
class TypeLookupTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                    getByName()
    *******************************************************************************************************************/
    
    
    /**
     * Ensure TypeLookup->getByName() returns a Type with the same name
     * 
     * @dataProvider getGetByNameTypeNameData()
     */
    public function testGetByNameTypeName( string $typeName, string $expected )
    {
        $this->assertEquals(
            $expected,
            $this->getTypeLookup()->getByName( $typeName )->getName(),
            'TypeLookup->getByName() returned a Type instance with the wrong name.'
        );
    }


    /**
     * Provides test data for GetByNameTypeName() test
     * 
     * @return array
     */
    public function getGetByNameTypeNameData(): array
    {
        return [
            'array'         => [ 'array',         'array' ],
            'bool'          => [ 'bool',          'bool' ],
            'boolean'       => [ 'boolean',       'bool' ],
            'int'           => [ 'int',           'int' ],
            'integer'       => [ 'integer',       'int' ],
            'function'      => [ 'function',      'function' ],
            'substr'        => [ 'substr',        'function' ],
            'double'        => [ 'double',        'float' ],
            'float'         => [ 'float',        'float' ],
            'null'          => [ 'null',          'null' ],
            'NULL'          => [ 'NULL',          'null' ],
            'string'        => [ 'string',        'string' ],
            'Iterator'      => [ 'Iterator',      'Iterator' ],
            Sequence::class => [ Sequence::class, Sequence::class ]
        ];
    }




    /*******************************************************************************************************************
    *                                                  UTILITY METHODS
    *******************************************************************************************************************/


    /**
     * Retrieve a (singleton) instance of the TypeLookup
     * 
     * @return TypeLookup
     */
    private function getTypeLookup(): TypeLookup
    {
        static $typeLookup = null;
        if ( null === $typeLookup ) {
            $typeLookup = new TypeLookup();
        }
        return $typeLookup;
    }
}