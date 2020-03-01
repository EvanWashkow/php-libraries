<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types;

use PHP\Collections\Sequence;
use PHP\Tests\Types\TypeLookupTest\ArrayTypeDetails;
use PHP\Tests\Types\TypeLookupTest\BooleanTypeDetails;
use PHP\Tests\Types\TypeLookupTest\ClassTypeDetails;
use PHP\Tests\Types\TypeLookupTest\FloatTypeDetails;
use PHP\Tests\Types\TypeLookupTest\FunctionInstanceTypeDetails;
use PHP\Tests\Types\TypeLookupTest\FunctionTypeDetails;
use PHP\Tests\Types\TypeLookupTest\IExpectedTypeDetails;
use PHP\Tests\Types\TypeLookupTest\IntegerTypeDetails;
use PHP\Tests\Types\TypeLookupTest\InterfaceTypeDetails;
use PHP\Tests\Types\TypeLookupTest\NullTypeDetails;
use PHP\Tests\Types\TypeLookupTest\StringTypeDetails;
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
     * @dataProvider getExpectedTypeDetails()
     */
    public function testGetByXTypeName( Type $type, IExpectedTypeDetails $expected ): void
    {
        $this->assertEquals(
            $expected->getTypeNames()[ 0 ],
            $type->getName(),
            'TypeLookup->getByX() returned a Type instance with the wrong name.'
        );
    }


    /**
     * Ensure TypeLookup->getByXs() returns a Type with the same names (primary + aliases)
     * 
     * @dataProvider getExpectedTypeDetails()
     */
    public function testGetByXTypeNames( Type $type, IExpectedTypeDetails $expected ): void
    {
        $this->assertEquals(
            $expected->getTypeNames(),
            $type->getNames()->toArray(),
            'TypeLookup->getByX() returned a Type instance with the wrong name.'
        );
    }


    /**
     * Ensure TypeLookup->getByX() returns the correct type
     * 
     * @dataProvider getExpectedTypeDetails()
     */
    public function testGetByXReturnType( Type $type, IExpectedTypeDetails $expected ): void
    {
        $this->assertInstanceOf(
            $expected->getTypeClassName(),
            $type,
            'TypeLookup->getByX() returned the wrong type.'
        );
    }


    /**
     * Retrieve IExpectedTypeDetails to run tests against
     * 
     * @return array
     */
    public function getExpectedTypeDetails(): array
    {
        $typeLookup = $this->getTypeLookup();

        return [

            /**
             * TypeLookup->getByName()
             */
            'TypeLookup->getByName( TypeNames::ARRAY )' => [
                $typeLookup->getByName( TypeNames::ARRAY ),
                new ArrayTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::BOOL )' => [
                $typeLookup->getByName( TypeNames::BOOL ),
                new BooleanTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::BOOLEAN )' => [
                $typeLookup->getByName( TypeNames::BOOLEAN ),
                new BooleanTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::FUNCTION )' => [
                $typeLookup->getByName( TypeNames::FUNCTION ),
                new FunctionTypeDetails()
            ],
            'TypeLookup->getByName( \'substr\' )' => [
                $typeLookup->getByName( 'substr' ),
                new FunctionInstanceTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::DOUBLE )' => [
                $typeLookup->getByName( TypeNames::DOUBLE ),
                new FloatTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::FLOAT )' => [
                $typeLookup->getByName( TypeNames::FLOAT ),
                new FloatTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::INT )' => [
                $typeLookup->getByName( TypeNames::INT ),
                new IntegerTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::INTEGER )' => [
                $typeLookup->getByName( TypeNames::INTEGER ),
                new IntegerTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::NULL )' => [
                $typeLookup->getByName( TypeNames::NULL ),
                new NullTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::STRING )' => [
                $typeLookup->getByName( TypeNames::STRING ),
                new StringTypeDetails()
            ],
            'TypeLookup->getByName( \Iterator::class )' => [
                $typeLookup->getByName( \Iterator::class ),
                new InterfaceTypeDetails( \Iterator::class )
            ],
            'TypeLookup->getByName( Sequence::class )' => [
                $typeLookup->getByName( Sequence::class ),
                new ClassTypeDetails( Sequence::class )
            ]
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