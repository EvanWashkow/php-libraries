<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Tests\Unit\Type\Single;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IEquatable;
use PHP\Tests\Interfaces\IEquatableTests;
use EvanWashkow\PhpLibraries\Type\Single\Type;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Type class
 */
final class TypeTest extends TestCase
{
    /**
     * Checks the type of Type
     */
    public function testType(): void
    {
        $this->assertInstanceOf(
            IEquatable::class,
            $this->mockType('integer')
        );
    }


    /**
     * Ensures __construct() throws a DomainException on invalid type names
     *
     * @dataProvider getConstructorExceptionTestData
     *
     * @param string $typeName
     */
    public function testConstructorException(string $typeName): void
    {
        $this->expectException(\DomainException::class);
        $this->mockType($typeName);
    }

    public function getConstructorExceptionTestData(): array
    {
        return [
            '' => [''],
            ' ' => [' '],
            ' integer' => [' integer'],
            'integer ' => ['integer '],
            ' integer ' => [' integer '],
            'integer string' => ['integer string'],
        ];
    }


    /**
     * Test getName() results
     *
     * @dataProvider getNamesTestData
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

    public function getNamesTestData(): array
    {
        return [
            'bool' => ['bool'],
            'float' => ['float'],
            'integer' => ['integer'],
        ];
    }


    /**
     * Ensures that is() throws InvalidArgumentException for wrong types
     *
     * @dataProvider getIsThrowsInvalidArgumentExceptionTestData
     *
     * @param $type
     */
    public function testIsThrowsInvalidArgumentException($type): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mockType('MockedType')->is($type);
    }

    public function getIsThrowsInvalidArgumentExceptionTestData(): array
    {
        return [
            'is(5)' => [5],
            'is(true)' => [true],
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
}
