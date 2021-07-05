<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Unit\Type\Composite;

use EvanWashkow\PhpLibraries\Tests\Unit\Type\TestDefinition\TypeTestDefinition;
use EvanWashkow\PhpLibraries\Type\Composite\UnionType;
use EvanWashkow\PhpLibraries\Type\Single\ArrayType;
use EvanWashkow\PhpLibraries\Type\Single\BooleanType;
use EvanWashkow\PhpLibraries\Type\Single\FloatType;
use EvanWashkow\PhpLibraries\Type\Single\IntegerType;
use EvanWashkow\PhpLibraries\Type\Single\StringType;
use EvanWashkow\PhpLibraries\Type\Type;

/**
 * Tests the UnionType class
 */
final class UnionTypeTest extends TypeTestDefinition
{

    /**
     * @inheritDoc
     */
    public function getIsTestData(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getIsUnknownTypeNameTestData(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getIsValueOfTypeTestData(): array
    {
        $true = new class extends Type
        {
            public function __construct()
            {
                parent::__construct('ReturnsTrue');
            }
            public function isValueOfType($value): bool
            {
                return true;
            }
            protected function isOfType(Type $type): bool
            {
                throw new \Exception('should not be called');
            }
            protected function isOfTypeName(string $typeName): bool
            {
                throw new \Exception('should not be called');
            }
        };
        $false = new class extends Type
        {
            public function __construct()
            {
                parent::__construct('ReturnsFalse');
            }
            public function isValueOfType($value): bool
            {
                return false;
            }
            protected function isOfType(Type $type): bool
            {
                throw new \Exception('should not be called');
            }
            protected function isOfTypeName(string $typeName): bool
            {
                throw new \Exception('should not be called');
            }
        };

        return [
            'true, true' => [
                new UnionType($true, $true),
                'does not matter',
                true
            ],
            'true, false' => [
                new UnionType($true, $false),
                'does not matter',
                true
            ],
            'false, true' => [
                new UnionType($false, $true),
                'does not matter',
                true
            ],
            'false, false' => [
                new UnionType($false, $false),
                'does not matter',
                false
            ],

            'true, false, false' => [
                new UnionType($true, $false, $false),
                'does not matter',
                true
            ],
            'false, true, false' => [
                new UnionType($false, $true, $false),
                'does not matter',
                true
            ],
            'false, false, true' => [
                new UnionType($false, $false, $true),
                'does not matter',
                true
            ],
            'false, false, false' => [
                new UnionType($false, $false, $false),
                'does not matter',
                false
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getNameTestData(): array
    {
        return [
            'integer|string' => [
                new UnionType(new IntegerType(), new StringType()),
                'integer|string'
            ],
            'boolean|integer' => [
                new UnionType(new BooleanType(), new IntegerType()),
                'boolean|integer'
            ],
            'boolean|integer|float' => [
                new UnionType(new BooleanType(), new IntegerType(), new FloatType()),
                'boolean|integer|float'
            ],
        ];
    }
}
