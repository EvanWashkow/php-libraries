<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Builds test data for Types.
 */
final class TypeTestDataBuilder
{
    private string $testName;
    private Type $type;
    private array $isValueOfType;
    private array $notIsValueOfType;

    public function __construct(string $testName, Type $type)
    {
        $this->testName = $testName;
        $this->type = $type;
        $this->isValueOfType = [];
        $this->notIsValueOfType = [];
    }

    /**
     * Add a test for isValueOfType().
     *
     * @param string $testedName the name of the value being tested
     * @param mixed  $value      the value being tested
     */
    public function isValueOfType(string $testedName, mixed $value): self
    {
        $this->isValueOfType["{$this->testName} IS VALUE OF TYPE {$testedName}"] =
            $this->newTestData($value, true);

        return $this;
    }

    /**
     * Add a test for !isValueOfType().
     *
     * @param string $testedName the name of the value being tested
     * @param mixed  $value      the value being tested
     */
    public function notIsValueOfType(string $testedName, mixed $value): self
    {
        $this->notIsValueOfType["{$this->testName} IS NOT VALUE OF TYPE {$testedName}"] =
            $this->newTestData($value, false);

        return $this;
    }

    /**
     * Builds isValueOfType() test data.
     */
    public function build(): array
    {
        if (count($this->isValueOfType) <= 1 || count($this->notIsValueOfType) <= 1) {
            throw new \DomainException('insufficient test cases for Type->isValueOfType()');
        }

        return array_merge($this->isValueOfType, $this->notIsValueOfType);
    }

    private function newTestData($value, bool $expected): array
    {
        return [$this->type, $value, $expected];
    }
}
