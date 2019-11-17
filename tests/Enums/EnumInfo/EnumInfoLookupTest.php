<?php
declare(strict_types=1);

namespace PHP\Tests\Enums\EnumInfo;

use PHP\Enums\EnumInfo\EnumInfo;
use PHP\Enums\EnumInfo\EnumInfoLookup;
use PHP\Enums\EnumInfo\StringEnumInfo;
use PHP\Tests\Enums\TestEnumDefinitions\MixedEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum Info Lookup methods
 */
class EnumInfoLookupTest extends TestCase
{


    /***************************************************************************
    *                            get() EXCEPTION TESTS
    ***************************************************************************/


    /**
     * Test get() throws InvalidArgumentException
     * 
     * @expectedException \InvalidArgumentException
     */
    public function testGetThrowsInvalidArgumentException()
    {
        (new EnumInfoLookup())->get( 1 );
    }


    /**
     * Test get() throws NotFoundException
     * 
     * @expectedException \PHP\Exceptions\NotFoundException
     */
    public function testGetThrowsNotFoundException()
    {
        (new EnumInfoLookup())->get( 'foobar' );
    }




    /***************************************************************************
    *                             get() RETURN TEST
    ***************************************************************************/


    /**
     * Test get() return an EnumInfo instance by Enum class name
     * 
     * @dataProvider getEnumInfoClasses()
     */
    public function testGetReturnsEnumInfoByClassName(
        EnumInfo $enumInfo,
        string   $enumInfoTypeName
    )
    {
        $this->assertInstanceOf(
            $enumInfoTypeName,
            $enumInfo,
            "EnumInfoLookup->get() did not return the corresponding EnumInfo instance"
        );
    }


    /**
     * Retrieve the enums data
     * 
     * @return array
     */
    public function getEnumInfoClasses(): array
    {
        $lookup = new EnumInfoLookup();
        return [
            'MixedEnum' => [
                $lookup->get( MixedEnum::class ),
                EnumInfo::class
            ],
            'StringEnum' => [
                $lookup->get( GoodStringEnum::class ),
                StringEnumInfo::class
            ]
        ];
    }


    /**
     * Test get() return an EnumInfo instance by Enum instance
     */
    public function testGetReturnsEnumInfoByInstance()
    {
        $this->assertInstanceOf(
            EnumInfo::class,
            ( new EnumInfoLookup() )->get( new MixedEnum( MixedEnum::STRING ) ),
            "EnumInfoLookup->get() did not return an EnumInfo instance"
        );
    }
}