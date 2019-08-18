<?php
declare(strict_types=1);

namespace PHP\Tests\Enums\EnumInfo;

use PHP\Enums\EnumInfo\EnumInfoLookup;
use PHP\ObjectClass;
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
     * Test __construct() throws NotFoundException
     * 
     * @expectedException \PHP\Exceptions\NotFoundException
     */
    public function testGetThrowsNotFoundException()
    {
        (new EnumInfoLookup())->get( 'foobar' );
    }


    /**
     * Test __construct() throws DomainException
     * 
     * @expectedException \DomainException
     */
    public function testGetThrowsDomainException()
    {
        (new EnumInfoLookup())->get( ObjectClass::class );
    }


    /**
     * Test __construct() throws InvalidArgumentException
     * 
     * @expectedException \InvalidArgumentException
     */
    public function testGetThrowsInvalidArgumentException()
    {
        (new EnumInfoLookup())->get( 1 );
    }
}