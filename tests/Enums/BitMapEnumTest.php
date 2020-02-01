<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Enums\BitMapEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodBitMapEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test the BitMapEnum class
 */
class BitMapEnumTest extends TestCase
{


    /**
     * Test the contains() function
     * 
     * @dataProvider getContainsData()
     */
    public function testContains( BitMapEnum $enum, int $bits, bool $expected ): void
    {
        $this->assertEquals(
            $expected,
            $enum->contains( $bits ),
            'BitMapEnum->contains() did not return the expected result'
        );
    }


    public function getContainsData(): array
    {
        return [
            'GoodBitMapEnum( GoodBitMapEnum::ONE )->contains( GoodBitMapEnum::ONE )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodBitMapEnum::ONE,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE )->contains( GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodBitMapEnum::FOUR,
                false
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->contains( GoodBitMapEnum::ONE )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->contains( GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::FOUR,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->contains( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->contains( GoodBitMapEnum::TWO )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::TWO,
                false
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->contains( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR,
                false
            ]
        ];
    }
}