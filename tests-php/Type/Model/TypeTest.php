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
     * @param string $name The type name
     */
    private function mockType(string $name): Type
    {
        return $this
            ->getMockBuilder(Type::class)
            ->setConstructorArgs([$name])
            ->getMock();
    }
}
