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
