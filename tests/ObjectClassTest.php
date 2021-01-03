<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\Collections\ByteArray;
use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTests;
use PHPUnit\Framework\TestCase;

/**
 * Tests ObjectClass methods
 */
class ObjectClassTest extends TestCase
{


    /**
     * Test hash() return value
     *
     * @dataProvider getHashTestData
     *
     * @param ObjectClass $objectClass
     * @param ByteArray $byteArray
     * @param bool $expected
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

        // Seed the hash of o1, and clone o1 as o3. Cloning an object should clear its hash.
        $o1->hash();
        $o3 = clone $o1;

        // Test data
        return
            [
                'o1, o1'       => [ $o1, $o1->hash(), true ],
                'o1, o2'       => [ $o1, $o2->hash(), false ],

                // Cloning an Object Class should clear its hash
                'o1, clone o1' => [ $o1, $o3->hash(), false ]
            ];
    }


    /**
     * Test equals() return value
     *
     * @dataProvider getEqualsTestData
     *
     * @param ObjectClass $objectClass
     * @param $value
     * @param bool $expected
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
        $o3 = clone $o1;

        // Test Data
        return [
            'o1, o1' => [ $o1, $o1, true ],
            'o1, o2' => [ $o1, $o2, false ],
            'o1, o3' => [ $o1, $o3, false ]
        ];
    }


    /**
     * Ensure hash() and equals() behave consistently
     *
     * @dataProvider getEqualsAndHashConsistencyTestData
     *
     * @param ObjectClass $objectClass1
     * @param ObjectClass $objectClass2
     */
    public function testEqualsAndHashConsistency(ObjectClass $objectClass1, ObjectClass $objectClass2): void
    {
        $this->getIEquatableTests()->testEqualsAndHashConsistency($objectClass1, $objectClass2);
    }

    public function getEqualsAndHashConsistencyTestData(): array
    {
        $o1 = $this->createObjectClass();
        return [
            'o1' => [ $o1, $o1 ]
        ];
    }


    /**
     * Retrieve IEquatable Tests for this Test Case
     * @return IEquatableTests
     */
    private function getIEquatableTests(): IEquatableTests
    {
        static $iequatableTests = null;
        if (null === $iequatableTests)
        {
            $iequatableTests = new IEquatableTests($this);
        }
        return $iequatableTests;
    }


    /**
     * Create a new Object Class
     * 
     * @return ObjectClass
     */
    private function createObjectClass(): ObjectClass
    {
        return new class extends ObjectClass {};
    }
}