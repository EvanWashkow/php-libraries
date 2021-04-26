<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\AnonymousType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\IntegerType;
use PHP\Type\Model\Type;

class AnonymousTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsOfTypeTestData(): array
    {
        return [
            'is(AnonymousType)' => [$this->createType(), true],
            'is(BooleanType)' => [new BooleanType(), false],
            'is(FloatType)' => [new FloatType(), false],
            'is(IntegerType)' => [new IntegerType(), false],
        ];
    }


    public function getIsOfTypeNameTestData(): array
    {
        return [
            'is(*)' => ['*', true],
            'is(bool)' => ['bool', false],
            'is(float)' => ['float', false],
            'is(integer)' => ['integer', false],
        ];
    }


    public function getIsTestData(): array
    {
        return array_merge(
            $this->getIsOfTypeTestData(),
            $this->getIsOfTypeNameTestData()
        );
    }


    public function getIsValueOfTypeTestData(): array
    {
        return [
            'isValueOfType([])'    => [[],    false],
            'isValueOfType(1)'     => [1,     false],
            'isValueOfType(2.7)'   => [2.7,   false],
            'isValueOfType(false)' => [false, false],
        ];
    }


    protected function createType(): Type
    {
        return new AnonymousType();
    }


    protected function getExpectedTypeName(): string
    {
        return '*';
    }
}
