<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\Type;
use PHPUnit\Framework\TestCase;

/**
 * Tests Types
 */
final class TypeTest extends TestCase
{
    /**
     * @dataProvider getTestCases
     */
    public function testFinal(TypeTestCase $tc)
    {
        $rc = new \ReflectionClass($tc->getType());
        $this->assertTrue($rc->isFinal(), "Type is not final");
    }

    /**
     * @dataProvider getTestCases
     */
    public function testEquals(TypeTestCase $tc)
    {
        foreach ($tc->getEquals() as $value) {
            $this->assertTrue(
                $tc->getType()->equals($value)
            );
        }
    }

    /**
     * @dataProvider getTestCases
     */
    public function testNotEquals(TypeTestCase $tc)
    {
        foreach ($tc->getNotEquals() as $value) {
            $this->assertFalse(
                $tc->getType()->equals($value)
            );
        }
    }

    /**
     * @dataProvider getTestCases
     */
    public function testIs(TypeTestCase $tc)
    {
        foreach ($tc->getIs() as $value) {
            $this->assertTrue(
                $tc->getType()->is($value)
            );
        }
    }

    /**
     * @dataProvider getTestCases
     */
    public function testNotIs(TypeTestCase $tc)
    {
        foreach ($tc->getNotIs() as $value) {
            $this->assertFalse(
                $tc->getType()->is($value)
            );
        }
    }

    /**
     * @dataProvider getTestCases
     */
    public function testIsValueOfType(TypeTestCase $tc)
    {
        foreach ($tc->getIsValueOfType() as $value) {
            $this->assertTrue(
                $tc->getType()->isValueOfType($value)
            );
        }
    }

    /**
     * @dataProvider getTestCases
     */
    public function testNotIsValueOfType(TypeTestCase $tc)
    {
        foreach ($tc->getNotIsValueOfType() as $value) {
            $this->assertFalse(
                $tc->getType()->isValueOfType($value)
            );
        }
    }

    /**
     * Retrieve TypeTestCases
     *
     * @return array<TypeTestCase>
     */
    public function getTestCases(): array
    {
        $typeMock = $this->createMock(Type::class);
        $notEquals = [
            $typeMock,
            1,
            false,
            'string',
            3.1415,
            []
        ];

        return [
            ArrayType::class => [
                (new TypeTestCaseBuilder(new ArrayType()))
                    ->equals(new ArrayType())
                    ->notEquals(...$notEquals)
                    ->is(new ArrayType())
                    ->notIs($typeMock)
                    ->build()
            ],
        ];
    }
}