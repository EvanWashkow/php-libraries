<?php

declare(strict_types=1);

namespace PHP\Tests;

use PHP\Collections\ByteArray;
use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTests;
use PHPUnit\Framework\TestCase;

/**
 * Tests ObjectClass methods.
 *
 * @internal
 * @coversNothing
 */
class ObjectClassTest extends TestCase
{
    /**
     * Test hash() return value.
     *
     * @dataProvider getHashTestData
     */
    public function testHash(ObjectClass $objectClass, ByteArray $byteArray, bool $expected): void
    {
        $this->getIEquatableTests()->testHash($objectClass, $byteArray, $expected);
    }

    public function getHashTestData(): array
    {
        // Objects
        $o1 = $this->createObjectClass();
        $o2 = $this->createObjectClass();

        // Hashes
        $o1Hash = new ByteArray(spl_object_hash($o1));
        $o2Hash = new ByteArray(spl_object_hash($o2));

        // Test data
        return [
            'o1, o1' => [$o1, $o1Hash,             true],
            'o1, o2' => [$o1, $o2Hash,             false],
            'o1, clone o1' => [$o1, (clone $o1)->hash(), false],
        ];
    }

    /**
     * Test equals() return value.
     *
     * @dataProvider getEqualsTestData
     *
     * @param $value
     */
    public function testEquals(ObjectClass $objectClass, $value, bool $expected): void
    {
        $this->getIEquatableTests()->testEquals($objectClass, $value, $expected);
    }

    public function getEqualsTestData(): array
    {
        // Objects
        $o1 = $this->createObjectClass();
        $o2 = $this->createObjectClass();

        // Test Data
        return [
            'o1, o1' => [$o1, $o1,       true],
            'o1, o2' => [$o1, $o2,       false],
            'o1, o3' => [$o1, clone $o1, false],
        ];
    }

    /**
     * Ensure hash() and equals() behave consistently.
     *
     * @dataProvider getEqualsAndHashConsistencyTestData
     */
    public function testEqualsAndHashConsistency(ObjectClass $objectClass1, ObjectClass $objectClass2): void
    {
        $this->getIEquatableTests()->testEqualsAndHashConsistency($objectClass1, $objectClass2);
    }

    public function getEqualsAndHashConsistencyTestData(): array
    {
        $o1 = $this->createObjectClass();

        return [
            'o1' => [$o1, $o1],
        ];
    }

    /**
     * Retrieve IEquatable Tests for this Test Case.
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
     * Create a new Object Class.
     */
    private function createObjectClass(): ObjectClass
    {
        return new class() extends ObjectClass {};
    }
}
