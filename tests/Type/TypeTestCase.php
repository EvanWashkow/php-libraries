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
    private array $isValueOfType;
    private array $notIsValueOfType;

    public function __construct(Type $type, array $equals, array $notEquals, array $is, array $notIs, array $isValueOfType, array $notIsValueOfType)
    {
        $this->type = $type;
        $this->equals = $equals;
        $this->notEquals = $notEquals;
        $this->is = $is;
        $this->notIs = $notIs;
        $this->isValueOfType = $isValueOfType;
        $this->notIsValueOfType = $notIsValueOfType;
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

    public function getIsValueOfType(): array
    {
        return $this->isValueOfType;
    }

    public function getNotIsValueOfType(): array
    {
        return $this->notIsValueOfType;
    }
}
