<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\ArrayType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\Type;

/**
 * Tests the FloatType class
 */
final class FloatTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsTestData(): array
    {
        return [

            // Same type
            'is(double)' => ['double', true],
            'is(float)' => ['float', true],
            'is(FloatType)' => [$this->createType(), true],
            'is(MockFloatType)' => [
                $this->createMock(FloatType::class),
                true
            ],

            /**
             * Different types
             *
             * @todo Add different Type instances to this test
             */
            'is(array)' => ['array', false],
            'is(ArrayType)' => [new ArrayType(), false],
            'is(bool)' => ['bool', false],
            'is(integer)' => ['integer', false],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        return [
            'isValueOfType(-8.9)' => [-8.9, true],
            'isValueOfType(1.0)' => [1.0, true],
            'isValueOfType(31.4)' => [31.4, true],
            'isValueOfType([])' => [[], false],
            'isValueOfType(false)' => [false, false],
            'isValueOfType(1)' => [1, false],
        ];
    }


    protected function createType(): Type
    {
        return new FloatType();
    }


    protected function getExpectedTypeName(): string
    {
        return 'float';
    }
}
