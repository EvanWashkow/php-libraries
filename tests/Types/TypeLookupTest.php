<?php
namespace PHP\Tests;

use PHP\Collections\Sequence;
use PHP\Types\Models\ClassType;
use PHP\Types\Models\FunctionType;
use PHP\Types\Models\InterfaceType;
use PHP\Types\Models\Type;
use PHP\Types\TypeLookup;
use PHPUnit\Framework\TestCase;

/**
 * Test TypeLookup class
 */
class TypeLookupTest extends TestCase
{




    /*******************************************************************************************************************
    *                                                    getByName()
    *******************************************************************************************************************/


    /**
     * Ensure TypeLookup->getByName() throws a DomainException
     * 
     * @expectedException \DomainException
     */
    public function testGetByNameDomainException(): void
    {
        $this->getTypeLookup()->getByName( 'foobar' );
    }


    /**
     * Ensure TypeLookup->getByName() returns a Type with the same name
     * 
     * @dataProvider getGetByNameTypeNameData()
     */
    public function testGetByNameTypeName( string $typeName, string $expected ): void
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
            'float'         => [ 'float',         'float' ],
            'null'          => [ 'null',          'null' ],
            'NULL'          => [ 'NULL',          'null' ],
            'string'        => [ 'string',        'string' ],
            'Iterator'      => [ 'Iterator',      'Iterator' ],
            Sequence::class => [ Sequence::class, Sequence::class ]
        ];
    }
    
    
    /**
     * Ensure TypeLookup->getByName() returns the correct type
     * 
     * @dataProvider getGetByNameReturnTypeData()
     */
    public function testGetByNameReturnType( string $typeName, string $expected ): void
    {
        $this->assertInstanceOf(
            $expected,
            $this->getTypeLookup()->getByName( $typeName ),
            'TypeLookup->getByName() returned the wrong type.'
        );
    }


    /**
     * Provides test data for GetByNameReturnType() test
     * 
     * @return array
     */
    public function getGetByNameReturnTypeData(): array
    {
        return [
            'array'         => [ 'array',         Type::class ],
            'bool'          => [ 'bool',          Type::class ],
            'boolean'       => [ 'boolean',       Type::class ],
            'int'           => [ 'int',           Type::class ],
            'integer'       => [ 'integer',       Type::class ],
            'function'      => [ 'function',      FunctionType::class ],
            'substr'        => [ 'substr',        FunctionType::class ],
            'double'        => [ 'double',        Type::class ],
            'float'         => [ 'float',         Type::class ],
            'null'          => [ 'null',          Type::class ],
            'NULL'          => [ 'NULL',          Type::class ],
            'string'        => [ 'string',        Type::class ],
            'Iterator'      => [ 'Iterator',      InterfaceType::class ],
            Sequence::class => [ Sequence::class, ClassType::class ]
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