<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\Collections\ByteArray;
use PHP\ObjectClass;
use PHP\Tests\Interfaces\IEquatableTests;
use PHP\Type\Model\Type;

/**
 * Tests the Type class
 */
final class TypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Checks the type of Type
     */
    public function testType(): void
    {
        $this->assertInstanceOf(
            ObjectClass::class,
            $this->mockType('integer')
        );
    }


    /**
     * Test getName() results
     *
     * @dataProvider getGetNamesTestData
     *
     * @param string $typeName
     */
    public function testGetName(string $typeName): void
    {
        $this->assertEquals(
            $typeName,
            $this->mockType($typeName)->getName(),
            Type::class . '->getName() did not return the expected type name.'
        );
    }

    public function getGetNamesTestData(): array
    {
        return [
            'bool'    => ['bool'],
            'float'   => ['float'],
            'integer' => ['integer'],
        ];
    }


    /**
     * Ensures that is() is correctly hooked up to its abstract sub-methods
     *
     * @dataProvider getIsCallsSubMethodsTestData
     *
     * @param Type $typeA
     * @param $typeB
     * @param bool $expected
     */
    public function testIsCallsSubMethods(Type $typeA, $typeB, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            $typeA->is($typeB),
            Type::class . '->is() did not return the expected value.'
        );
    }

    public function getIsCallsSubMethodsTestData(): array
    {
        $mockedTypeName = 'MockedType';
        $mockedType     = $this->mockType($mockedTypeName);

        return [
            'is(5) - wrong type' => [
                $mockedType,
                5,
                false
            ],
            'is(true) - wrong type' => [
                $mockedType,
                true,
                false
            ],
            'is() calls isOfType(); isOfType() returns true' => [
                $this->mockTypeIsOfType($mockedTypeName, true),
                $mockedType,
                true
            ],
            'is() calls isOfType(); isOfType() returns false' => [
                $this->mockTypeIsOfType($mockedTypeName, false),
                $mockedType,
                false
            ],
        ];
    }


    /**
     * Test hash() results
     *
     * @dataProvider getHashTestData
     *
     * @param string $typeName The type name
     */
    public function testHash(string $typeName): void
    {
        $this->getEquatableTests()->testHash(
            $this->mockType($typeName),
            new ByteArray($typeName),
            true
        );
    }

    public function getHashTestData(): array
    {
        return [
            'bool'    => ['bool'],
            'float'   => ['float'],
            'integer' => ['integer'],
        ];
    }


    /**
     * Test equals() returns the expected result
     *
     * @dataProvider getEqualsTestData
     *
     * @param string $typeName The type name as a string
     * @param mixed  $value    The value to compare to
     * @param bool   $expected The expected result of equatable->equals()
     */
    public function testEquals(string $typeName, $value, bool $expected): void
    {
        $this->getEquatableTests()->testEquals($this->mockType($typeName), $value, $expected);
    }

    public function getEqualsTestData(): array
    {
        return [
            /**
             * equals(string)
             */
            'array === array'     => ['array', 'array', true],
            'array !== float'     => ['array', 'float',  false],
            'integer === integer' => ['integer', 'integer', true],
            'integer !== string'  => ['integer', 'string',  false],

            /**
             * equals(Type)
             */
            'bool === Type(bool)'       => ['bool',    $this->mockType('bool'),    true],
            'bool !== Type(string)'     => ['bool',    $this->mockType('string'),  false],
            'integer === Type(integer)' => ['integer', $this->mockType('integer'), true],
            'integer !== Type(bool)'    => ['integer', $this->mockType('bool'),    false],

            /**
             * equals( <wrong_type> )
             */
            'integer === true' => ['integer', true, false],
            'integer === 1'    => ['integer', 1,    false],
        ];
    }


    /**
     * Tests the consistency of equals() and hash() as described on IEquatable
     *
     * @dataProvider getEqualsAndHashConsistencyTestData
     *
     * @param Type $type1 The Type to do the comparison
     * @param Type $type2 The Type to compare to
     */
    public function testEqualsAndHashConsistency(Type $type1, Type $type2): void
    {
        $this->getEquatableTests()->testEqualsAndHashConsistency($type1, $type2);
    }

    public function getEqualsAndHashConsistencyTestData(): array
    {
        return [
            'array, array' => [
                $this->mockType('array'),
                $this->mockType('array')
            ],
            'bool, bool' => [
                $this->mockType('bool'),
                $this->mockType('bool')
            ],
            'float, float' => [
                $this->mockType('float'),
                $this->mockType('float')
            ],
            'integer, integer' => [
                $this->mockType('integer'),
                $this->mockType('integer')
            ],
            'string, string' => [
                $this->mockType('string'),
                $this->mockType('string')
            ],
        ];
    }


    /**
     * Retrieves IEquatableTests instance for this test
     */
    private function getEquatableTests(): IEquatableTests
    {
        static $equatableTest = null;
        if ($equatableTest === null)
        {
            $equatableTest = new IEquatableTests($this);
        }
        return $equatableTest;
    }


    /**
     * Retrieve type instance for this test
     *
     * @param string $typeName The type name
     */
    private function mockType(string $typeName): Type
    {
        return $this
            ->getMockBuilder(Type::class)
            ->setConstructorArgs([$typeName])
            ->getMock();
    }


    /**
     * Mock Type->isOfType()
     *
     * @param string $typeName The type name
     * @param bool $returnValue The return value
     */
    private function mockTypeIsOfType(string $typeName, bool $returnValue): Type
    {
        return new class($typeName, $returnValue) extends Type
        {
            private $returnValue;

            public function __construct(string $typeName, $returnValue)
            {
                parent::__construct($typeName);
                $this->returnValue = $returnValue;
            }

            public function isValueOfType($value): bool
            {
                return true;
            }

            protected function isOfType(Type $type): bool
            {
                return $this->returnValue;
            }
        };
    }
}
