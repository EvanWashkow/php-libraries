<?php
declare(strict_types=1);

namespace PHP\Tests\Enums\EnumInfo;

use PHP\Enums\EnumInfo\EnumInfo;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum Info methods
 */
class EnumInfoTest extends TestCase
{


    /**
     * Test __construct() throws NotFoundException
     * 
     * @expectedException \PHP\Exceptions\NotFoundException
     */
    public function testConstructThrowsNotFoundException()
    {
        new EnumInfo( 'foobar' );
    }
}