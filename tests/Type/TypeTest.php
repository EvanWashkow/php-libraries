<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\ClassType;
use EvanWashkow\PHPLibraries\Type\FloatType;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\InterfaceType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests Types
 */
final class TypeTest extends TestCase
{
    /**
     * @dataProvider getFinalTestData
     */
    public function testFinal(TypeInterface $type): void
    {
        $rc = new \ReflectionClass($type);
        $this->assertTrue($rc->isFinal(), "Type is not final");
    }

    public function getFinalTestData(): array
    {
        $data = [];
        foreach ($this->getTestBuilders() as $builder) {
            $type = $builder->getType();
            $data[get_class($type)] = [$type];
        }
        return $data;
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
                function() {
                    new ClassType('');
                },
                \DomainException::class
            ],
            "{$classType}('foobar')" => [
                function() {
                    new ClassType('foobar');
                },
                \DomainException::class
            ],
            "{$classType}(StubInterfaceA)" => [
                function() {
                    new ClassType(StubInterfaceA::class);
                },
                \DomainException::class
            ],
            "{$interfaceType}('')" => [
                function() {
                    new InterfaceType('');
                },
                \DomainException::class
            ],
            "{$interfaceType}('foobar')" => [
                function() {
                    new InterfaceType('foobar');
                },
                \DomainException::class
            ],
            "{$interfaceType}(StubClassA)" => [
                function() {
                    new InterfaceType(StubClassA::class);
                },
                \DomainException::class
            ],
        ];
    }


    /**
     * @dataProvider getIsTestData
     */
    public function testIs(TypeInterface $tester, TypeInterface $testee, bool $expected): void
    {
        $this->assertSame($expected, $tester->is($testee));
    }

    public function getIsTestData(): array
    {
        $data = [];
        foreach ($this->getTestBuilders() as $builder) {
            $data = array_merge($data, $builder->buildIsTestData());
        }
        return $data;
    }


    /**
     * @dataProvider getIsValueOfTypeTestData
     */
    public function testIsValueOfType(TypeInterface $type, $value, bool $expected): void
    {
        $this->assertSame($expected, $type->isValueOfType($value));
    }

    public function getIsValueOfTypeTestData(): array
    {
        $data = [];
        foreach ($this->getTestBuilders() as $builder) {
            $data = array_merge($data, $builder->buildIsValueOfTypeTestData());
        }
        return $data;
    }


    /**
     * Retrieves the TypeTestDataBuilders
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
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->notIs('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class))
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
                ->is('StubClassA', new ClassType(StubClassA::class))
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->is('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class))
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
                ->notIs('StubInterfaceB', new InterfaceType(StubInterfaceB::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassA', new ClassType(StubClassA::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class))
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
                ->is('StubInterfaceA', new InterfaceType(StubInterfaceA::class))
                ->notIs('StubInterfaceC', new InterfaceType(StubInterfaceC::class))
                ->notIs('StubClassA', new ClassType(StubClassA::class))
                ->notIs('StubClassB', new ClassType(StubClassB::class))
                ->notIs('StubClassC', new ClassType(StubClassC::class))
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
     * Creates a new default TypeTestDataBuilder
     */
    private function newTestBuilder(string $testName, TypeInterface $type): TypeTestDataBuilder
    {
        return (new TypeTestDataBuilder($testName, $type))
            ->notIs('Type mock', $this->createMock(TypeInterface::class));
    }
}