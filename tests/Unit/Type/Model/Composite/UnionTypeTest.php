<?php
declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\Composite;

use EvanWashkow\PhpLibraries\Tests\Unit\Type\Model\TestDefinition\TypeTestDefinition;
use EvanWashkow\PhpLibraries\Type\Model\Composite\UnionType;
use EvanWashkow\PhpLibraries\Type\Model\Single\BooleanType;
use EvanWashkow\PhpLibraries\Type\Model\ClassType\ClassType;
use EvanWashkow\PhpLibraries\Type\Model\Single\FloatType;
use EvanWashkow\PhpLibraries\Type\Model\Single\IntegerType;
use EvanWashkow\PhpLibraries\Type\Model\Single\InterfaceType;
use EvanWashkow\PhpLibraries\Type\Model\Single\StringType;
use EvanWashkow\PhpLibraries\Type\Model\Type;
use PHP\Interfaces\IEquatable;

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
        return [
            'int|bool is int' => [
                new UnionType(new IntegerType(), new BooleanType()),
                new IntegerType(),
                false,
            ],
            'int|bool is bool' => [
                new UnionType(new IntegerType(), new BooleanType()),
                new BooleanType(),
                false,
            ],
            'IntegerType|BooleanType is ReflectionClass' => [
                new UnionType(
                    new ClassType(new \ReflectionClass(IntegerType::class)),
                    new ClassType(new \ReflectionClass(BooleanType::class)),
                ),
                new ClassType(new \ReflectionClass(\ReflectionClass::class)),
                false
            ],
            'IntegerType|BooleanType is Throwable' => [
                new UnionType(
                    new ClassType(new \ReflectionClass(IntegerType::class)),
                    new ClassType(new \ReflectionClass(BooleanType::class)),
                ),
                new InterfaceType(new \ReflectionClass(\Throwable::class)),
                false
            ],
            'IntegerType|BooleanType is Type' => [
                new UnionType(
                    new ClassType(new \ReflectionClass(IntegerType::class)),
                    new ClassType(new \ReflectionClass(BooleanType::class)),
                ),
                new ClassType(new \ReflectionClass(Type::class)),
                true
            ],
            'IntegerType|BooleanType is IEquatable' => [
                new UnionType(
                    new ClassType(new \ReflectionClass(IntegerType::class)),
                    new ClassType(new \ReflectionClass(BooleanType::class)),
                ),
                new InterfaceType(new \ReflectionClass(IEquatable::class)),
                true
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIsUnknownTypeNameTestData(): array
    {
        return [
            UnionType::class => [new UnionType(new IntegerType(), new BooleanType())],
        ];
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
