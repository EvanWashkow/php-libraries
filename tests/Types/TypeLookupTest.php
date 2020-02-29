<?php
namespace PHP\Tests;

use PHP\Collections\Sequence;
use PHP\Types\Models\ClassType;
use PHP\Types\Models\FunctionType;
use PHP\Types\Models\InterfaceType;
use PHP\Types\Models\Type;
use PHP\Types\TypeLookup;
use PHP\Types\TypeNames;
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
     * Ensure TypeLookup->getByName() returns a Type with the same primary name
     * 
     * @dataProvider getGetByNameTypeNamesData()
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
     * Ensure TypeLookup->getByNames() returns a Type with the same names (primary + aliases)
     * 
     * @dataProvider getGetByNameTypeNamesData()
     */
    public function testGetByNameTypeNames( string $typeName, string ...$expected ): void
    {
        $this->assertEquals(
            $expected,
            $this->getTypeLookup()->getByName( $typeName )->getNames()->toArray(),
            'TypeLookup->getByName() returned a Type instance with the wrong name.'
        );
    }


    /**
     * Provides test data for GetByNameTypeNames() test
     * 
     * @return array
     */
    public function getGetByNameTypeNamesData(): array
    {
        return [
            TypeNames::ARRAY    => [ TypeNames::ARRAY,    TypeNames::ARRAY ],
            TypeNames::BOOL     => [ TypeNames::BOOL,     TypeNames::BOOL,  TypeNames::BOOLEAN ],
            TypeNames::BOOLEAN  => [ TypeNames::BOOLEAN,  TypeNames::BOOL,  TypeNames::BOOLEAN ],
            TypeNames::INT      => [ TypeNames::INT,      TypeNames::INT,   TypeNames::INTEGER ],
            TypeNames::INTEGER  => [ TypeNames::INTEGER,  TypeNames::INT,   TypeNames::INTEGER ],
            TypeNames::FUNCTION => [ TypeNames::FUNCTION, TypeNames::FUNCTION ],
            'substr'            => [ 'substr',            TypeNames::FUNCTION ],
            TypeNames::DOUBLE   => [ TypeNames::DOUBLE,   TypeNames::FLOAT, TypeNames::DOUBLE ],
            TypeNames::FLOAT    => [ TypeNames::FLOAT,    TypeNames::FLOAT, TypeNames::DOUBLE ],
            TypeNames::NULL     => [ TypeNames::NULL,     TypeNames::NULL ],
            TypeNames::STRING   => [ TypeNames::STRING,   TypeNames::STRING ],
            'Iterator'      => [ 'Iterator',              'Iterator' ],
            Sequence::class => [ Sequence::class,         Sequence::class ]
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