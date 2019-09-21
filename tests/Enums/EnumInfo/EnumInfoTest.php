<?php
declare(strict_types=1);

namespace PHP\Tests\Enums\EnumInfo;

use PHP\Enums\EnumInfo\EnumInfo;
use PHP\ObjectClass;
use PHP\Tests\Enums\EnumTest\MixedEnum;
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
}