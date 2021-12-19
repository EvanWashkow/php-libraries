<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\Type;

final class TypeTestCase
{
    private Type $type;
    private array $equals;
    private array $notEquals;
    private array $is;
    private array $notIs;

    public function __construct(Type $type, array $equals, array $notEquals, array $is, array $notIs)
    {
        $this->type = $type;
        $this->equals = $equals;
        $this->notEquals = $notEquals;
        $this->is = $is;
        $this->notIs = $notIs;
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

    public function getIs(): array
    {
        return $this->is;
    }

    public function getNotIs(): array
    {
        return $this->notIs;
    }
}
