<?php
declare(strict_types=1);

namespace PHP\Tests\Enums\EnumInfo;

use PHP\Enums\EnumInfo\EnumInfo;
use PHP\Enums\EnumInfo\EnumInfoLookup;
use PHP\ObjectClass;
use PHP\Tests\Enums\EnumTest\MixedEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum Info Lookup methods
 */
class EnumInfoLookupTest extends TestCase
{


    /***************************************************************************
    *                                get()
    ***************************************************************************/


    /**
     * Test get() throws NotFoundException
     * 
     * @expectedException \PHP\Exceptions\NotFoundException
     */
    public function testGetThrowsNotFoundException()
    {
        (new EnumInfoLookup())->get( 'foobar' );
    }


    /**
     * Test get() throws DomainException on non-classes
     * 
     * @expectedException \DomainException
     */
    public function testGetThrowsDomainExceptionOnNonClasses()
    {
        (new EnumInfoLookup())->get( 'int' );
    }


    /**
     * Test get() throws DomainException on non-Enum classes
     * 
     * @expectedException \DomainException
     */
    public function testGetThrowsDomainExceptionOnNonEnumClasses()
    {
        (new EnumInfoLookup())->get( ObjectClass::class );
    }


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
     * Test get() return an EnumInfo instance by Enum class name
     */
    public function testGetReturnsEnumInfoByClassName()
    {
        $this->assertInstanceOf(
            EnumInfo::class,
            ( new EnumInfoLookup() )->get( MixedEnum::class ),
            "EnumInfoLookup->get() did not return an EnumInfo instance"
        );
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