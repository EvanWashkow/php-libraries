<?php

declare(strict_types=1);

namespace PHP\Tests\Enums;

use PHP\Collections\Sequence;
use PHP\Enums\BitMapEnum;
use PHP\Tests\Enums\TestEnumDefinitions\GoodBitMapEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test the BitMapEnum class.
 *
 * @internal
 * @coversNothing
 */
class BitMapEnumTest extends TestCase
{
    /**
     * Ensure isSet() throws InvalidArgumentException.
     */
    public function testIsSetException(): void
    {
        $enum = new GoodBitMapEnum(GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR);
        $this->expectException(\InvalidArgumentException::class);
        $enum->isSet(new Sequence('int', [GoodBitMapEnum::FOUR]));
    }

    /**
     * Test the isSet() function.
     *
     * @dataProvider getIsSetReturnData()
     *
     * @param mixed $bitMap
     */
    public function testIsSetReturn(BitMapEnum $enum, $bitMap, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $enum->isSet($bitMap),
            'BitMapEnum->isSet() did not return the expected result'
        );
    }

    public function getIsSetReturnData(): array
    {
        return [
            // BitMapEnum->isSet( int )
            'GoodBitMapEnum( GoodBitMapEnum::ONE )->isSet( GoodBitMapEnum::ONE )' => [
                new GoodBitMapEnum(GoodBitMapEnum::ONE),
                GoodBitMapEnum::ONE,
                true,
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE )->isSet( GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum(GoodBitMapEnum::ONE),
                GoodBitMapEnum::FOUR,
                false,
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::ONE )' => [
                new GoodBitMapEnum(GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR),
                GoodBitMapEnum::ONE,
                true,
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum(GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR),
                GoodBitMapEnum::FOUR,
                true,
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum(GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR),
                GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR,
                true,
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::TWO )' => [
                new GoodBitMapEnum(GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR),
                GoodBitMapEnum::TWO,
                false,
            ],
            'GoodBitMapEnum( GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR )->isSet( GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR )' => [
                new GoodBitMapEnum(GoodBitMapEnum::ONE | GoodBitMapEnum::FOUR),
                GoodBitMapEnum::ONE | GoodBitMapEnum::TWO | GoodBitMapEnum::FOUR,
                false,
            ],

            // BitMapEnum->isSet( BitMapEnum )
            'GoodBitMapEnum( GoodBitMapEnum::ONE )->isSet( GoodBitMapEnum( GoodBitMapEnum::ONE ) )' => [
                new GoodBitMapEnum(GoodBitMapEnum::ONE),
                new GoodBitMapEnum(GoodBitMapEnum::ONE),
                true,
            ],
        ];
    }
}
