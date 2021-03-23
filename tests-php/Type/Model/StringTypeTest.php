<?php
declare(strict_types = 1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\ArrayType;
use PHP\Type\Model\BooleanType;
use PHP\Type\Model\StringType;
use PHP\Type\Model\FloatType;
use PHP\Type\Model\Type;

/**
 * Tests the StringType class
 */
final class StringTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsTestData(): array
    {
        return [

            // Same type
            'is(string)' => ['string', true],
            'is(StringType)' => [$this->createType(), true],
            'is(MockStringType)' => [
                $this->createMock(StringType::class),
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
            'is(BooleanType)' => [new BooleanType(), false],
            'is(float)' => ['float', false],
            'is(FloatType)' => [new FloatType(), false],
        ];
    }


    public function getIsValueOfTypeTestData(): array
    {
        return [
            'isValueOfType(foobar)' => ['foobar', true],
            'isValueOfType(lorem)' => ['lorem', true],
            'isValueOfType(ipsum)' => ['ipsum', true],
            'isValueOfType(1)' => [1, false],
            'isValueOfType([])' => [[], false],
            'isValueOfType(1.0)' => [1.0, false],
            'isValueOfType(2.7)' => [2.7, false],
            'isValueOfType(false)' => [false, false],
        ];
    }


    protected function createType(): Type
    {
        return new StringType();
    }


    protected function getExpectedTypeName(): string
    {
        return 'string';
    }
}
