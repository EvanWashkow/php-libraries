<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests ObjectClass methods
 */
class ObjectClassTest extends TestCase
{

    /**
     * Define test data for IEquatableTestTrait
     */
    use IEquatableTestTrait;


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


    public function getEqualsAndHashConsistencyTestData(): array
    {
        $o1 = $this->createObjectClass();
        return [
            'o1' => [ $o1, $o1 ]
        ];
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