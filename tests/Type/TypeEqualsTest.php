<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Tests\EquatableInterface\AbstractEquatableTestDefinition;
use EvanWashkow\PHPLibraries\Tests\EquatableInterface\EquatableTestDataBuilder;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\BooleanType;
use EvanWashkow\PHPLibraries\Type\FloatType;
use EvanWashkow\PHPLibraries\Type\Type;

final class TypeEqualsTest extends AbstractEquatableTestDefinition
{
    public function getTestData(): array
    {
        return array_merge(
            $this->newDefaultTestDataBuilder(ArrayType::class, new ArrayType())->build(),
            $this->newDefaultTestDataBuilder(BooleanType::class, new BooleanType())->build(),
            $this->newDefaultTestDataBuilder(FloatType::class, new FloatType())->build(),
        );
    }


    private function newDefaultTestDataBuilder(string $testNamePrefix, Type $type): EquatableTestDataBuilder
    {
        return (new EquatableTestDataBuilder($testNamePrefix, $type))
            ->equals('clone', clone $type)
            ->notEquals('Type mock', $this->createMock(Type::class))
            ->notEquals('integer', 1)
            ->notEquals('bool', false)
            ->notEquals('string', 'string')
            ->notEquals('float', 3.1415)
            ->notEquals('array', []);
    }
}
