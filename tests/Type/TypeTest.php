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
     * @dataProvider getTypes
     */
    public function testFinal(Type $type)
    {
        $rc = new \ReflectionClass($type);
        $this->assertTrue($rc->isFinal(), "Type is not final");
    }

    /**
     * @dataProvider getEqualsData
     */
    public function testEquals(Type $type, $value, bool $expected)
    {
        $this->assertEquals(
            $expected,
            $type->equals($value)
        );
    }

    public function getEqualsData(): array
    {
        $tests = [];
        foreach ($this->getTypes() as $name => $test) {
            $type = $test[0];
            $tests = array_merge(
                $tests,
                [
                    "{$name}->equals(same Type)" => [
                        $type,
                        clone $type,
                        true
                    ],
                    "{$name}->equals(mock Type)" => [
                        $type,
                        $this->createMock(Type::class),
                        false
                    ],
                    "{$name}->equals(integer)" => [
                        $type,
                        1,
                        false
                    ],
                    "{$name}->equals(bool)" => [
                        $type,
                        false,
                        false
                    ],
                    "{$name}->equals(string)" => [
                        $type,
                        "string",
                        false
                    ],
                ]
            );
        }
        return $tests;
    }

    public function getTypes(): array
    {
        return [
            ArrayType::class => [new ArrayType()],
        ];
    }
}