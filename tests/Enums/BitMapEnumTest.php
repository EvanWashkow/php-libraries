<?php
declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Collections\Sequence;
use PHP\Enums\BitMapEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodBitMapEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test the BitMapEnum class
 */
class BitMapEnumTest extends TestCase
{


    /**
     * Ensure isSet() throws InvalidArgumentException
     * 
     * @expectedException \InvalidArgumentException
     */
    public function testIsSetException(): void
    {
        $enum = new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR );
        $enum->isSet( new Sequence( 'int', [ GoodBitMapEnum::FOUR ] ) );
    }


    /**
     * Test the isSet() function
     * 
     * @dataProvider getIsSetReturnData()
     */
    public function testIsSetReturn( BitMapEnum $enum, int $bit, bool $expected ): void
    {
        $this->assertEquals(
            $expected,
            $enum->isSet( $bit ),
            'BitMapEnum->isSet() did not return the expected result'
        );
    }


    public function getIsSetReturnData(): array
    {
        return [
            'GoodBitMapEnum( GoodBitMapEnum::ONE )->isSet( GoodBitMapEnum::ONE )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodBitMapEnum::ONE,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE )->isSet( GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE ),
                GoodBitMapEnum::FOUR,
                false
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::ONE )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::FOUR,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR,
                true
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::TWO )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::TWO,
                false
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR ),
                GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR,
                false
            ]
        ];
    }
}