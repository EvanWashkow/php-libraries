<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\Type;

final class TypeTestCase
{
    private Type $type;
    private array $equals;
    private array $notEquals;

    public function __construct(Type $type, array $equals, array $notEquals)
    {
        $this->type = $type;
        $this->equals = $equals;
        $this->notEquals = $notEquals;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getEquals(): array
    {
        return $this->equals;
    }

    public function getNotEquals(): array
    {
        return $this->notEquals;
    }
}
