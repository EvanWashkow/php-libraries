<?php

declare(strict_types=1);

namespace PHP\Tests\Collections\Strings;

use PHP\Collections\ByteArray;
use PHP\Collections\Strings\Hexadecimal;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTests;
use PHPUnit\Framework\TestCase;

class HexadecimalTest extends TestCase
{
    /**
     * Ensure Hexadecimal is of  the expected parent types
     *
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance(string $typeName)
    {
        $this->assertInstanceOf(
            $typeName,
            new Hexadecimal(new ByteArray('ABC')),
            Hexadecimal::class . " is not of type {$typeName}"
        );
    }

    public function getInheritanceTestData(): array
    {
        return [
            ObjectClass::class => [ ObjectClass::class ],
            IStringable::class => [ IStringable::class ]
        ];
    }


    /**
     * Test __toString()
     *
     * @dataProvider getToStringTestData
     */
    public function testToString(ByteArray $byteArray, string $expected)
    {
        $this->assertEquals(
            $expected,
            ( new Hexadecimal($byteArray))->__toString(),
            'Hexadecimal->__toString() did not return the expected hexadecimal string'
        );
    }

    public function getToStringTestData(): array
    {
        return [
            'A' => [
                new ByteArray('A'),
                '41'
            ],
            'B' => [
                new ByteArray('B'),
                '42'
            ],
            'C' => [
                new ByteArray('C'),
                '43'
            ],
            ':' => [
                new ByteArray(':'),
                '3a'
            ],
            ';' => [
                new ByteArray(';'),
                '3b'
            ],
            '?' => [
                new ByteArray('?'),
                '3f'
            ],
            'ABC:;?' => [
                new ByteArray('ABC:;?'),
                '4142433a3b3f'
            ],
            0x6e617645 => [
                new ByteArray(0x6e617645, 4), // Hexadecimal notation is little-endian
                '4576616e'                      // Hexadecimal strings are big-endian
            ],
            0x4100 => [
                new ByteArray(0x4100, 2),
                '0041'
            ],
            0x0041 => [
                new ByteArray(0x0041, 2),
                '4100'
            ],
            0x41 => [
                new ByteArray(0x41, 4),
                '41000000'
            ]
        ];
    }





    /*******************************************************************************************************************
     *                                                   IEquatable Tests
     ******************************************************************************************************************/


    /**
     * Retrieve IEquatable Tests for this Test Case
     * @return IEquatableTests
     */
    private function getIEquatableTests(): IEquatableTests
    {
        static $iequatableTests = null;
        if (null === $iequatableTests) {
            $iequatableTests = new IEquatableTests($this);
        }
        return $iequatableTests;
    }


    /**
     * Test hash() return value
     *
     * @dataProvider getHashTestData
     *
     * @param Hexadecimal $hexadecimal
     * @param ByteArray $byteArray
     * @param bool $expected
     */
    public function testHash(Hexadecimal $hexadecimal, ByteArray $byteArray, bool $expected): void
    {
        $this->getIEquatableTests()->testHash($hexadecimal, $byteArray, $expected);
    }

    public function getHashTestData(): array
    {
        $byteArray00 = new ByteArray(0x00, 2);
        $byteArrayaa = new ByteArray(0xaa, 2);
        $byteArrayff = new ByteArray(0xff, 2);
        return [
            'Hexadecimal(0x00)->hash() === ByteArray(0xff)' => [
                new Hexadecimal($byteArray00), $byteArrayff, false
            ],
            'Hexadecimal(0x00)->hash() === ByteArray(0x00)' => [
                new Hexadecimal($byteArray00), $byteArray00, true
            ],
            'Hexadecimal(0xaa)->hash() === ByteArray(0x00)' => [
                new Hexadecimal($byteArrayaa), $byteArray00, false
            ],
            'Hexadecimal(0xaa)->hash() === ByteArray(0xaa)' => [
                new Hexadecimal($byteArrayaa), $byteArrayaa, true
            ]
        ];
    }


    /**
     * Test equals() return value
     *
     * @dataProvider getEqualsTestData
     *
     * @param Hexadecimal $hexadecimal
     * @param $value
     * @param bool $expected
     */
    public function testEquals(Hexadecimal $hexadecimal, $value, bool $expected): void
    {
        $this->getIEquatableTests()->testEquals($hexadecimal, $value, $expected);
    }

    public function getEqualsTestData(): array
    {
        $byteArray00 = new ByteArray(0x00, 2);
        $byteArrayff = new ByteArray(0xff, 2);
        $hex00 = new Hexadecimal($byteArray00);
        $hexff = new Hexadecimal($byteArrayff);
        return [
            'Hexadecimal(0x00)->equals(0x00)' => [
                $hex00, 0x00, false
            ],
            'Hexadecimal(0x00)->equals(ByteArray(0x00))' => [
                $hex00, $byteArray00, false
            ],
            'Hexadecimal(0x00)->equals(Hexadecimal(0xff))' => [
                $hex00, $hexff, false
            ],
            'Hexadecimal(0x00)->equals(Hexadecimal(0x0000))' => [
                $hex00, new Hexadecimal(new ByteArray(0x00, 4)), false
            ],
            'Hexadecimal(0x00)->equals(Hexadecimal(0x00))' => [
                $hex00, clone $hex00, true
            ],
            'Hexadecimal(0xff)->equals(Hexadecimal(0xff))' => [
                $hexff, $hexff, true
            ]
        ];
    }


    /**
     * Ensure hash() and equals() are consistent
     *
     * @dataProvider getEqualsAndHashConsistencyTestData
     *
     * @param Hexadecimal $hexadecimal1
     * @param Hexadecimal $hexadecimal2
     */
    public function testEqualsAndHashConsistency(Hexadecimal $hexadecimal1, Hexadecimal $hexadecimal2): void
    {
        $this->getIEquatableTests()->testEqualsAndHashConsistency($hexadecimal1, $hexadecimal2);
    }

    public function getEqualsAndHashConsistencyTestData(): array
    {
        $byteArray00 = new ByteArray(0x00, 2);
        $byteArrayff = new ByteArray(0xff, 2);
        $hex00 = new Hexadecimal($byteArray00);
        $hexff = new Hexadecimal($byteArrayff);
        return [
            'Hexadecimal(0x00), Hexadecimal(0x00)' => [ $hex00, clone $hex00 ],
            'Hexadecimal(0xff), Hexadecimal(0xff)' => [ $hexff, clone $hexff ]
        ];
    }
}
