<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Enums\Enum;
use PHP\Enums\IntegerEnum;
use PHP\Tests\Enums\IntegerEnumTest\BadIntegerEnum;
use PHP\Tests\Enums\IntegerEnumTest\GoodIntegerEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test Enum class
 */
class IntegerEnumTest extends TestCase
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
            ( new GoodIntegerEnum( GoodIntegerEnum::ONE ))->getConstants()->getKeyType()->getName(),
            "IntegerEnum constant dictionary key type was not a string."
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
            'int',
            ( new GoodIntegerEnum( GoodIntegerEnum::ONE ))->getConstants()->getValueType()->getName(),
            "IntegerEnum constant dictionary value type was not a string."
        );
    }
}