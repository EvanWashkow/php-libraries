<?php
declare(strict_types=1);

namespace PHP\Tests\Enums\EnumInfo;

use PHP\Enums\EnumInfo\EnumInfo;
use PHP\Enums\EnumInfo\EnumInfoLookup;
use PHP\ObjectClass;
use PHP\Tests\Enums\TestEnumDefinitions\MixedEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHP\Types;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum Info methods
 */
class EnumInfoTest extends TestCase
{


    /***************************************************************************
    *                                __construct()
    ***************************************************************************/


    /**
     * Test class is an ObjectClass
     */
    public function testIsObjectClass()
    {
        $this->assertInstanceOf(
            ObjectClass::class,
            new EnumInfo( Types::GetByName( MixedEnum::class ) ),
            'EnumInfo does not extend ObjectClass'
        );
    }


    /**
     * Test __construct() throws DomainException
     * 
     * @expectedException \DomainException
     */
    public function testConstructThrowsDomainException()
    {
        new EnumInfo( Types::GetByName( ObjectClass::class ) );
    }



    /***************************************************************************
    *                                getConstants()
    ***************************************************************************/


    /**
     * Test the constants returned from EnumInfo->getConstants
     * 
     * @dataProvider getConstants()
     */
    public function testGetConstants( EnumInfo $enumInfo, array $constants )
    {
        $this->assertEquals(
            $constants,
            $enumInfo->getConstants()->toArray(),
            "EnumInfo->getConstants() did not return the correct constants."
        );
    }


    public function getConstants(): array
    {
        $lookup = new EnumInfoLookup();
        return [
            'MixedEnum' => [
                $lookup->get( MixedEnum::class ),
                [
                    'ARRAY'   => MixedEnum::ARRAY,
                    'NUMBERS' => MixedEnum::NUMBERS,
                    'STRING'  => MixedEnum::STRING
                ]
            ],
            'IntegerEnum' => [
                $lookup->get( GoodIntegerEnum::class ),
                [
                    'ONE'  => GoodIntegerEnum::ONE,
                    'TWO'  => GoodIntegerEnum::TWO,
                    'FOUR' => GoodIntegerEnum::FOUR
                ]
            ],
            'StringEnum' => [
                $lookup->get( GoodStringEnum::class ),
                [
                    'ONE'  => GoodStringEnum::ONE,
                    'TWO'  => GoodStringEnum::TWO,
                    'FOUR' => GoodStringEnum::FOUR
                ]
            ]
        ];
    }
}