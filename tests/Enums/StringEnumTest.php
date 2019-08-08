<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Enums\StringEnum;
use PHP\Tests\Enums\StringEnumTest\BadStringEnum;
use PHP\Tests\Enums\StringEnumTest\GoodStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum class
 */
class StringEnumTest extends TestCase
{




    /***************************************************************************
    *                                    getConstants()
    ***************************************************************************/


    /**
     * Test get constants key type
     * 
     * If constants were broken, other tests would prove the same
     */
    public function testGetConstantsKeyType()
    {
        $this->assertEquals(
            'string',
            ( new GoodStringEnum( GoodStringEnum::A ))->getConstants()->getKeyType()->getName(),
            "StringEnum constant dictionary key type was not a string."
        );
    }


    /**
     * Test get constants value type
     * 
     * If constants were broken, other tests would prove the same
     */
    public function testGetConstantsValueType()
    {
        $this->assertEquals(
            'string',
            ( new GoodStringEnum( GoodStringEnum::A ))->getConstants()->getValueType()->getName(),
            "StringEnum constant dictionary value type was not a string."
        );
    }
}