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
     * Retrieve TypeTestCases
     *
     * @return array<TypeTestCase>
     */
    public function getTestCases(): array
    {
        $notEquals = [
            $this->createMock(Type::class),
            1,
            false,
            "string",
            3.1415,
        ];

        return [
            ArrayType::class => [
                (new TypeTestCaseBuilder(new ArrayType()))
                    ->equals(new ArrayType())
                    ->notEquals(...$notEquals)
                    ->build()
            ],
        ];
    }
}