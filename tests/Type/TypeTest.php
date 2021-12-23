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
     * @dataProvider getTestCases
     */
    public function testFinal(TypeTestCase $tc)
    {
        $rc = new \ReflectionClass($tc->getType());
        $this->assertTrue($rc->isFinal(), "Type is not final");
    }

    /**
     * Retrieve TypeTestCases
     *
     * @return array<TypeTestCase>
     */
    public function getTestCases(): array
    {
        $typeMock = $this->createMock(Type::class);
        $notEquals = [
            $typeMock,
            1,
            false,
            'string',
            3.1415,
            []
        ];

        return [
            ArrayType::class => [
                (new TypeTestCaseBuilder(new ArrayType()))
                    ->equals(new ArrayType())
                    ->notEquals(...$notEquals)
                    ->is(new ArrayType())
                    ->notIs($typeMock)
                    ->isValueOfType([], [1,2,3], ['a', 'b', 'c'])
                    ->notIsValueOfType(1, false, 'string', 3.1415)
                    ->build()
            ],
            BooleanType::class => [
                (new TypeTestCaseBuilder(new BooleanType()))
                    ->equals(new BooleanType())
                    ->notEquals(...$notEquals)
                    ->is(new BooleanType())
                    ->notIs($typeMock)
                    ->isValueOfType(true, false)
                    ->notIsValueOfType(1, 'string', 3.1415, [])
                    ->build()
            ],
        ];
    }
}