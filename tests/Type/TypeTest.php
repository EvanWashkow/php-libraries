<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\Type;
use PHPUnit\Framework\TestCase;

/**
 * Tests Types
 */
final class TypeTest extends TestCase
{
    /**
     * @dataProvider getFinalTestData
     */
    public function testFinal(Type $type): void
    {
        $rc = new \ReflectionClass($type);
        $this->assertTrue($rc->isFinal(), "Type is not final");
    }

    public function getFinalTestData(): array
    {
        $data = [];
        foreach ($this->getTestDataBuilders() as $builder) {
            $type = $builder->getType();
            $data[get_class($type)] = [$type];
        }
        return $data;
    }


    /**
     * @dataProvider getIsTestData
     */
    public function testIs(Type $tester, Type $testee, bool $expected): void
    {
        $this->assertSame($expected, $tester->is($testee));
    }

    public function getIsTestData(): array
    {
        $data = [];
        foreach ($this->getTestDataBuilders() as $builder) {
            $data = array_merge($data, $builder->buildIsTestData());
        }
        return $data;
    }


    /**
     * @dataProvider getIsValueOfTypeTestData
     */
    public function testIsValueOfType(Type $type, $value, bool $expected): void
    {
        $this->assertSame($expected, $type->isValueOfType($value));
    }

    public function getIsValueOfTypeTestData(): array
    {
        $data = [];
        foreach ($this->getTestDataBuilders() as $builder) {
            $data = array_merge($data, $builder->buildIsValueOfTypeTestData());
        }
        return $data;
    }


    /**
     * Retrieves the TypeTestDataBuilders
     *
     * @return array<TypeTestDataBuilder>
     */
    public function getTestDataBuilders(): array
    {
        $typeMock = $this->createMock(Type::class);

        return [
            (new TypeTestDataBuilder(ArrayType::class, new ArrayType()))
                ->notIs('Type mock', $typeMock)
                ->isValueOfType('empty array', [])
                ->isValueOfType('full array', [1, 2, 3])
                ->notIsValueOfType('bool', false)
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),
            (new TypeTestDataBuilder(BooleanType::class, new BooleanType()))
                ->notIs('Type mock', $typeMock)
                ->isValueOfType('true', true)
                ->isValueOfType('false', false)
                ->notIsValueOfType('array', [])
                ->notIsValueOfType('float', 3.1415)
                ->notIsValueOfType('integer', 1)
                ->notIsValueOfType('string', 'string'),
        ];
    }
}