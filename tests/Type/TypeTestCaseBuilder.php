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

    /**
     * Type->equals() these values.
     *
     * @param mixed ...$equals
     * @return self
     */
    public function equals(...$equals): self
    {
        $this->equals = $equals;
        return $this;
    }

    /**
     * ! Type->equals() these values.
     *
     * @param mixed ...$notEquals
     * @return self
     */
    public function notEquals(...$notEquals): self
    {
        $this->notEquals = $notEquals;
        return $this;
    }

    /**
     * Build a TypeTestCase
     * 
     * @throws \UnexpectedValueException on bad TypeTestCase data
     */
    public function build(): TypeTestCase
    {
        if (
            count($this->equals) == 0 ||
            count($this->notEquals) <= 1
        ) {
            throw new \UnexpectedValueException('insufficient data to build TypeTestCase');
        }
        return new TypeTestCase(
            $this->type,
            $this->equals,
            $this->notEquals
        );
    }
}