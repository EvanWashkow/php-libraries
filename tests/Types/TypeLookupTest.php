<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types;

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
    *                                               getByName() / getByValue()
    *******************************************************************************************************************/


    /**
     * Ensure TypeLookup->getByName() throws a DomainException
     * 
     * @expectedException \DomainException
     */
    public function testGetByXDomainException(): void
    {
        $this->getTypeLookup()->getByName( 'foobar' );
    }


    /**
     * Ensure TypeLookup->getByX() returns a Type with the same primary name
     * 
     * @dataProvider getGetByXTypeNamesData()
     */
    public function testGetByXTypeName( Type $type, string $expected ): void
    {
        $this->assertEquals(
            $expected,
            $type->getName(),
            'TypeLookup->getByX() returned a Type instance with the wrong name.'
        );
    }


    /**
     * Ensure TypeLookup->getByXs() returns a Type with the same names (primary + aliases)
     * 
     * @dataProvider getGetByXTypeNamesData()
     */
    public function testGetByXTypeNames( Type $type, string ...$expected ): void
    {
        $this->assertEquals(
            $expected,
            $type->getNames()->toArray(),
            'TypeLookup->getByX() returned a Type instance with the wrong name.'
        );
    }


    /**
     * Provides test data for GetByXTypeNames() test
     * 
     * @return array
     */
    public function getGetByXTypeNamesData(): array
    {
        $typeLookup = $this->getTypeLookup();

        return [


            /**
             * TypeLookup->getByName()
             */
            "TypeLookup->getByName( TypeNames::ARRAY )" => [
                $typeLookup->getByName( TypeNames::ARRAY ),
                TypeNames::ARRAY
            ],
            "TypeLookup->getByName( TypeNames::BOOL )" => [
                $typeLookup->getByName( TypeNames::BOOL ),
                TypeNames::BOOL,
                TypeNames::BOOLEAN
            ],
            "TypeLookup->getByName( TypeNames::BOOLEAN )" => [
                $typeLookup->getByName( TypeNames::BOOLEAN ),
                TypeNames::BOOL,
                TypeNames::BOOLEAN
            ],
            "TypeLookup->getByName( TypeNames::INT )" => [
                $typeLookup->getByName( TypeNames::INT ),
                TypeNames::INT,
                TypeNames::INTEGER
            ],
            "TypeLookup->getByName( TypeNames::INTEGER )" => [
                $typeLookup->getByName( TypeNames::INTEGER ),
                TypeNames::INT,
                TypeNames::INTEGER
            ],
            "TypeLookup->getByName( TypeNames::FUNCTION )" => [
                $typeLookup->getByName( TypeNames::FUNCTION ),
                TypeNames::FUNCTION
            ],
            "TypeLookup->getByName( 'substr' )" => [
                $typeLookup->getByName( 'substr' ),
                TypeNames::FUNCTION
            ],
            "TypeLookup->getByName( TypeNames::DOUBLE )" => [
                $typeLookup->getByName( TypeNames::DOUBLE ),
                TypeNames::FLOAT,
                TypeNames::DOUBLE
            ],
            "TypeLookup->getByName( TypeNames::FLOAT )" => [
                $typeLookup->getByName( TypeNames::FLOAT ),
                TypeNames::FLOAT,
                TypeNames::DOUBLE
            ],
            "TypeLookup->getByName( TypeNames::NULL )" => [
                $typeLookup->getByName( TypeNames::NULL ),
                TypeNames::NULL
            ],
            "TypeLookup->getByName( TypeNames::STRING )" => [
                $typeLookup->getByName( TypeNames::STRING ),
                TypeNames::STRING
            ],
            "TypeLookup->getByName( \Iterator::class )" => [
                $typeLookup->getByName( \Iterator::class ),
                \Iterator::class
            ],
            "TypeLookup->getByName( Sequence::class )" => [
                $typeLookup->getByName( Sequence::class ),
                Sequence::class
            ]
        ];
    }
    
    
    /**
     * Ensure TypeLookup->getByX() returns the correct type
     * 
     * @dataProvider getGetByXReturnTypeData()
     */
    public function testGetByXReturnType( Type $type, string $expected ): void
    {
        $this->assertInstanceOf(
            $expected,
            $type,
            'TypeLookup->getByX() returned the wrong type.'
        );
    }


    /**
     * Provides test data for GetByXReturnType() test
     * 
     * @return array
     */
    public function getGetByXReturnTypeData(): array
    {
        $typeLookup = $this->getTypeLookup();

        return [


            /**
             * TypeLookup->getByName()
             */
            "TypeLookup->getByName( TypeNames::ARRAY )" => [
                $typeLookup->getByName( TypeNames::ARRAY ),
                Type::class
            ],
            "TypeLookup->getByName( TypeNames::BOOL )" => [
                $typeLookup->getByName( TypeNames::BOOL ),
                Type::class
            ],
            "TypeLookup->getByName( TypeNames::BOOLEAN )" => [
                $typeLookup->getByName( TypeNames::BOOLEAN ),
                Type::class
            ],
            "TypeLookup->getByName( TypeNames::INT )" => [
                $typeLookup->getByName( TypeNames::INT ),
                Type::class
            ],
            "TypeLookup->getByName( TypeNames::INTEGER )" => [
                $typeLookup->getByName( TypeNames::INTEGER ),
                Type::class
            ],
            "TypeLookup->getByName( TypeNames::FUNCTION )" => [
                $typeLookup->getByName( TypeNames::FUNCTION ),
                Type::class
            ],
            "TypeLookup->getByName( 'substr' )" => [
                $typeLookup->getByName( 'substr' ),
                FunctionType::class
            ],
            "TypeLookup->getByName( TypeNames::DOUBLE )" => [
                $typeLookup->getByName( TypeNames::DOUBLE ),
                Type::class
            ],
            "TypeLookup->getByName( TypeNames::FLOAT )" => [
                $typeLookup->getByName( TypeNames::FLOAT ),
                Type::class
            ],
            "TypeLookup->getByName( TypeNames::NULL )" => [
                $typeLookup->getByName( TypeNames::NULL ),
                Type::class
            ],
            "TypeLookup->getByName( TypeNames::STRING )" => [
                $typeLookup->getByName( TypeNames::STRING ),
                Type::class
            ],
            "TypeLookup->getByName( 'Iterator' )" => [
                $typeLookup->getByName( 'Iterator' ),
                InterfaceType::class
            ],
            "TypeLookup->getByName( Sequence::class )" => [
                $typeLookup->getByName( Sequence::class ),
                ClassType::class
            ]
        ];
    }


    /**
     * Retrieve ExpectedTypeDetails to run tests against
     * 
     * @return array
     */
    public function getExpectedTypeDetails(): array
    {
        return [];
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