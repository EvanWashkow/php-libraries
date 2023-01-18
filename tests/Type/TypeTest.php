<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Type;

use EvanWashkow\PhpLibraries\Type\ArrayType;
use EvanWashkow\PhpLibraries\Type\BooleanType;
use EvanWashkow\PhpLibraries\Type\ClassType;
use EvanWashkow\PhpLibraries\Type\FloatType;
use EvanWashkow\PhpLibraries\Type\IntegerType;
use EvanWashkow\PhpLibraries\Type\InterfaceType;
use EvanWashkow\PhpLibraries\Type\StringType;
use EvanWashkow\PhpLibraries\TypeInterface\Type;
use PHPUnit\Framework\TestCase;

/**
 * Tests Types.
 *
 * @internal
 *
 * @coversNothing
 */
final class TypeTest extends TestCase
{
    /**
     * @dataProvider getFinalTestData
     */
    public function testFinal(Type $type): void
    {
        $rc = new \ReflectionClass($type);
        $this->assertTrue($rc->isFinal(), 'Type is not final');
    }

    public function getFinalTestData(): array
    {
        return [
            ArrayType::class => [new ArrayType()],
            BooleanType::class => [new BooleanType()],
            ClassType::class => [new ClassType(StubClassA::class)],
            FloatType::class => [new FloatType()],
            IntegerType::class => [new IntegerType()],
            InterfaceType::class => [new InterfaceType(StubInterfaceA::class)],
            StringType::class => [new StringType()],
        ];
    }

    /**
     * @dataProvider getConstructorExceptionTestData
     */
    public function testConstructorException(callable $fn, string $expected): void
    {
        $this->expectException($expected);
        $fn();
    }

    public function getConstructorExceptionTestData(): array
    {
        $classType = ClassType::class;
        $interfaceType = InterfaceType::class;

        return [
            "{$classType}('')" => [
                static function (): void {
                    new ClassType('');
                },
                \DomainException::class,
            ],
            "{$classType}('foobar')" => [
                static function (): void {
                    new ClassType('foobar');
                },
                \DomainException::class,
            ],
            "{$classType}(StubInterfaceA)" => [
                static function (): void {
                    new ClassType(StubInterfaceA::class);
                },
                \DomainException::class,
            ],
            "{$interfaceType}('')" => [
                static function (): void {
                    new InterfaceType('');
                },
                \DomainException::class,
            ],
            "{$interfaceType}('foobar')" => [
                static function (): void {
                    new InterfaceType('foobar');
                },
                \DomainException::class,
            ],
            "{$interfaceType}(StubClassA)" => [
                static function (): void {
                    new InterfaceType(StubClassA::class);
                },
                \DomainException::class,
            ],
        ];
    }

    /**
     * @dataProvider getIsValueOfTypeTestData
     */
    public function testIsValueOfType(Type $type, mixed $value, bool $expected): void
    {
        $this->assertSame($expected, $type->isValueOfType($value));
    }

    public function getIsValueOfTypeTestData(): array
    {
        $data = [];
        foreach ($this->getTestBuilders() as $builder) {
            $data = array_merge($data, $builder->build());
        }

        return $data;
    }

    /**
     * Retrieves the TypeTestDataBuilders.
     *
     * @return array<TypeTestDataBuilder>
     */
    public function getTestBuilders(): array
    {
        $classType = ClassType::class;
        $interfaceType = InterfaceType::class;

        return [
            $this->newTestBuilder(ArrayType::class, new ArrayType())
                ->isValueOfType('empty array', [])
                ->isValueOfType('full array', [1, 2, 3])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),
            $this->newTestBuilder(BooleanType::class, new BooleanType())
                ->isValueOfType('true', true)
                ->isValueOfType('false', false)
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),
            $this->newTestBuilder(FloatType::class, new FloatType())
                ->isValueOfType('3.1415', 3.1415)
                ->isValueOfType('1.5', 1.5)
                ->isValueOfType('-2.9', -2.9)
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),
            $this->newTestBuilder(IntegerType::class, new IntegerType())
                ->isValueOfType('PHP_INT_MAX', PHP_INT_MAX)
                ->isValueOfType('1', 1)
                ->isValueOfType('-1', -1)
                ->isValueOfType('PHP_INT_MIN', PHP_INT_MIN)
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('string', 'string'),
            $this->newTestBuilder(StringType::class, new StringType())
                ->isValueOfType('string', 'string')
                ->isValueOfType('empty string', '')
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1),

            $this->newTestBuilder("{$classType}(StubClassA)", new ClassType(StubClassA::class))
                ->isValueOfType('mockStubClassA', $this->createMock(StubClassA::class))
                ->isValueOfType('StubClassA', new StubClassA())
                ->isValueOfType('StubClassB', new StubClassB())
                ->isValueOfType('StubClassC', new StubClassC())
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),
            $this->newTestBuilder("{$classType}(StubClassB)", new ClassType(StubClassB::class))
                ->isValueOfType('mockStubClassB', $this->createMock(StubClassB::class))
                ->isValueOfType('StubClassB', new StubClassB())
                ->notIsValueOfType('StubClassA', new StubClassA())
                ->notIsValueOfType('StubClassC', new StubClassC())
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),

            $this->newTestBuilder("{$interfaceType}(StubInterfaceA)", new InterfaceType(StubInterfaceA::class))
                ->isValueOfType('mockStubInterfaceA', $this->createMock(StubInterfaceA::class))
                ->isValueOfType('StubClassA', new StubClassA())
                ->isValueOfType('StubClassB', new StubClassB())
                ->isValueOfType('StubClassC', new StubClassC())
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),
            $this->newTestBuilder("{$interfaceType}(StubInterfaceB)", new InterfaceType(StubInterfaceB::class))
                ->isValueOfType('StubClassB', new StubClassB())
                ->isValueOfType('mockStubInterfaceB', $this->createMock(StubInterfaceB::class))
                ->notIsValueOfType('StubClassA', new StubClassA())
                ->notIsValueOfType('StubClassC', new StubClassC())
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),
        ];
    }

    /**
     * Creates a new default TypeTestDataBuilder.
     */
    private function newTestBuilder(string $testName, Type $type): TypeTestDataBuilder
    {
        return new TypeTestDataBuilder($testName, $type);
    }
}
