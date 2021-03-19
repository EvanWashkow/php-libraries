<?php
declare(strict_types=1);

namespace PHP\Tests\Type\Model;

use PHP\Type\Model\AnonymousType;
use PHP\Type\Model\Type;

class AnonymousTypeTest extends TestDefinition\StaticTypeTestDefinition
{
    public function getIsTestData(): array
    {
        $mockType = $this->createMock(AnonymousType::class);

        return [

            // Same type
            'is(*)'             => ['*',                 true],
            'is(AnonymousType)' => [$this->createType(), true],
            'is(MockedAnonymousType)' => [
                $this->createMock(AnonymousType::class),
                true
            ],

            /**
             * Different types
             *
             * @todo Add different Type instances to this test
             */
            'is(bool)'    => ['bool',    false],
            'is(float)'   => ['float',   false],
            'is(integer)' => ['integer', false],
        ];
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