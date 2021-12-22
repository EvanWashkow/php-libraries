<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Tests\EquatableInterface\AbstractEquatableTestDefinition;
use EvanWashkow\PHPLibraries\Tests\EquatableInterface\EquatableTestDataBuilder;
use EvanWashkow\PHPLibraries\Type\ArrayType;
use EvanWashkow\PHPLibraries\Type\Type;

final class TypeEqualsTest extends AbstractEquatableTestDefinition
{
    public function getTestData(): array
    {
        return array_merge(
            $this->newDefaultTestDataBuilder(ArrayType::class, new ArrayType())->build(),
        );
    }


    private function newDefaultTestDataBuilder(string $testNamePrefix, Type $type): EquatableTestDataBuilder
    {
        $typeMock = $this->createMock(Type::class);
        return (new EquatableTestDataBuilder($testNamePrefix, $type))
            ->equals('clone', clone $type)
            ->notEquals('Type mock', $typeMock)
            ->notEquals('integer', 1)
            ->notEquals('bool', false)
            ->notEquals('string', 'string')
            ->notEquals('float', 3.1415)
            ->notEquals('array', []);
    }
}
