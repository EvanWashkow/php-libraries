<?php

declare(strict_types=1);

namespace PHP\Tests\Types;

use PHP\Collections\Sequence;
use PHP\Tests\Types\TypeLookupTest\ArrayTypeDetails;
use PHP\Tests\Types\TypeLookupTest\BooleanTypeDetails;
use PHP\Tests\Types\TypeLookupTest\ClassTypeDetails;
use PHP\Tests\Types\TypeLookupTest\FloatTypeDetails;
use PHP\Tests\Types\TypeLookupTest\FunctionTypeDetails;
use PHP\Tests\Types\TypeLookupTest\IntegerTypeDetails;
use PHP\Tests\Types\TypeLookupTest\InterfaceTypeDetails;
use PHP\Tests\Types\TypeLookupTest\NullTypeDetails;
use PHP\Tests\Types\TypeLookupTest\StringTypeDetails;
use PHP\Tests\Types\TypeLookupTest\TypeDetails;
use PHP\Types\Models\Type;
use PHP\Types\TypeLookupSingleton;
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
     */
    public function testGetByXDomainException(): void
    {
        $this->expectException(\DomainException::class);
        TypeLookupSingleton::getInstance()->getByName('foobar');
    }


    /**
     * Ensure TypeLookup->getByX() returns a Type with the same primary name
     *
     * @dataProvider getExpectedTypeDetails()
     */
    public function testGetByXTypeName(Type $type, TypeDetails $expected): void
    {
        $this->assertEquals(
            $expected->getNames()[ 0 ],
            $type->getName(),
            'TypeLookup->getByX() returned a Type instance with the wrong name.'
        );
    }


    /**
     * Ensure TypeLookup->getByXs() returns a Type with the same names (primary + aliases)
     *
     * @dataProvider getExpectedTypeDetails()
     */
    public function testGetByXTypeNames(Type $type, TypeDetails $expected): void
    {
        $this->assertEquals(
            $expected->getNames(),
            $type->getNames()->toArray(),
            'TypeLookup->getByX() returned a Type instance with the wrong name.'
        );
    }


    /**
     * Ensure TypeLookup->getByX() returns the correct type
     *
     * @dataProvider getExpectedTypeDetails()
     */
    public function testGetByXReturnType(Type $type, TypeDetails $expected): void
    {
        foreach ($expected->getTypeNames() as $typeName) {
            $this->assertInstanceOf(
                $typeName,
                $type,
                'TypeLookup->getByX() returned the wrong type.'
            );
        }
    }


    /**
     * Retrieve TypeDetails to run tests against
     *
     * @return array
     */
    public function getExpectedTypeDetails(): array
    {
        $typeLookup = TypeLookupSingleton::getInstance();

        return [

            /**
             * TypeLookup->getByName()
             */
            'TypeLookup->getByName( TypeNames::ARRAY )' => [
                $typeLookup->getByName(TypeNames::ARRAY),
                new ArrayTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::BOOL )' => [
                $typeLookup->getByName(TypeNames::BOOL),
                new BooleanTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::BOOLEAN )' => [
                $typeLookup->getByName(TypeNames::BOOLEAN),
                new BooleanTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::FUNCTION )' => [
                $typeLookup->getByName(TypeNames::FUNCTION),
                new FunctionTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::DOUBLE )' => [
                $typeLookup->getByName(TypeNames::DOUBLE),
                new FloatTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::FLOAT )' => [
                $typeLookup->getByName(TypeNames::FLOAT),
                new FloatTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::INT )' => [
                $typeLookup->getByName(TypeNames::INT),
                new IntegerTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::INTEGER )' => [
                $typeLookup->getByName(TypeNames::INTEGER),
                new IntegerTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::NULL )' => [
                $typeLookup->getByName(TypeNames::NULL),
                new NullTypeDetails()
            ],
            'TypeLookup->getByName( TypeNames::STRING )' => [
                $typeLookup->getByName(TypeNames::STRING),
                new StringTypeDetails()
            ],
            'TypeLookup->getByName( \Iterator::class )' => [
                $typeLookup->getByName(\Iterator::class),
                new InterfaceTypeDetails(\Iterator::class)
            ],
            'TypeLookup->getByName( Sequence::class )' => [
                $typeLookup->getByName(Sequence::class),
                new ClassTypeDetails(Sequence::class)
            ],


            /**
             * TypeLookup->getByValue()
             */
            'TypeLookup->getByValue( [ 1 ] )' => [
                $typeLookup->getByValue([ 1 ]),
                new ArrayTypeDetails()
            ],
            'TypeLookup->getByValue( true )' => [
                $typeLookup->getByValue(true),
                new BooleanTypeDetails()
            ],
            'TypeLookup->getByValue( 0.0 )' => [
                $typeLookup->getByValue(0.0),
                new FloatTypeDetails()
            ],
            'TypeLookup->getByValue( 1.0 )' => [
                $typeLookup->getByValue(1.0),
                new FloatTypeDetails()
            ],
            'TypeLookup->getByValue( 0 )' => [
                $typeLookup->getByValue(0),
                new IntegerTypeDetails()
            ],
            'TypeLookup->getByValue( 1 )' => [
                $typeLookup->getByValue(1),
                new IntegerTypeDetails()
            ],
            'TypeLookup->getByValue( NULL )' => [
                $typeLookup->getByValue(null),
                new NullTypeDetails()
            ],
            'TypeLookup->getByValue( \'1\' )' => [
                $typeLookup->getByValue('1'),
                new StringTypeDetails()
            ],
            'TypeLookup->getByValue( new Sequence( \'int\', [ 1 ] ))' => [
                $typeLookup->getByValue(new Sequence('int', [ 1 ])),
                new ClassTypeDetails(Sequence::class)
            ]
        ];
    }
}
