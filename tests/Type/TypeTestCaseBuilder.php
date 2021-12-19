<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\Type;

/**
 * Builds a TypeTestCase
 */
final class TypeTestCaseBuilder
{
    private Type $type;
    private array $equals;
    private array $notEquals;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * Type->equals() these values.
     *
     * @param mixed ...$equals
     * @return void
     */
    public function equals(...$equals)
    {
        $this->equals = $equals;
    }

    /**
     * ! Type->equals() these values.
     *
     * @param mixed ...$notEquals
     * @return void
     */
    public function notEquals(...$notEquals)
    {
        $this->notEquals = $notEquals;
    }

    /**
     * Build a TypeTestCase
     * 
     * @throws \UnexpectedValueException on bad TypeTestCase data
     */
    public function build(): TypeTestCase
    {
        return new TypeTestCase(clone $this);
    }
}