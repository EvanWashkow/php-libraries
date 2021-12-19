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
    private array $is;
    private array $notIs;
    private array $isValueOfType;
    private array $notIsValueOfType;

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
     * Type->is() these values.
     *
     * @param Type ...$is
     * @return self
     */
    public function is(Type ...$is): self
    {
        $this->is = $is;
        return $this;
    }

    /**
     * ! Type->is() these values.
     *
     * @param Type ...$notIs
     * @return self
     */
    public function notIs(Type ...$notIs): self
    {
        $this->notIs = $notIs;
        return $this;
    }

    /**
     * Type->isValueOfType() these values.
     *
     * @param mixed ...$isValueOfType
     * @return self
     */
    public function isValueOfType(...$isValueOfType): self
    {
        $this->isValueOfType = $isValueOfType;
        return $this;
    }

    /**
     * ! Type->isValueOfType() these values.
     *
     * @param mixed ...$notIsValueOfType
     * @return self
     */
    public function notIsValueOfType(...$notIsValueOfType): self
    {
        $this->notIsValueOfType = $notIsValueOfType;
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
            count($this->notEquals) <= 1 ||
            count($this->is) == 0 ||
            count($this->notIs) == 0 ||
            count($this->isValueOfType) <= 1 ||
            count($this->notIsValueOfType) <= 1
        ) {
            throw new \UnexpectedValueException('insufficient data to build TypeTestCase');
        }
        return new TypeTestCase(
            $this->type,
            $this->equals,
            $this->notEquals,
            $this->is,
            $this->notIs,
            $this->isValueOfType,
            $this->notIsValueOfType
        );
    }
}