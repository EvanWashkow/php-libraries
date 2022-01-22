<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * Builds test data for Types.
 */
final class TypeTestDataBuilder
{
    private string $testName;
    private TypeInterface $type;
    private array $isValueOfType;
    private array $notIsValueOfType;

    public function __construct(string $testName, TypeInterface $type)
    {
        $this->testName = $testName;
        $this->type = $type;
        $this->isValueOfType = [];
        $this->notIsValueOfType = [];
    }


    /**
     * Get the Type
     */ 
    public function getType(): TypeInterface
    {
        return $this->type;
    }


    /**
     * Add a test for isValueOfType()
     *
     * @param string $testedName The name of the value being tested.
     * @param mixed $value The value being tested.
     */
    public function isValueOfType(string $testedName, $value): self
    {
        $this->isValueOfType["{$this->testName} IS VALUE OF TYPE {$testedName}"] =
            $this->newIsValueOfTypeTestData($value, true);
        return $this;
    }


    /**
     * Add a test for !isValueOfType()
     *
     * @param string $testedName The name of the value being tested.
     * @param mixed $value The value being tested.
     */
    public function notIsValueOfType(string $testedName, $value): self
    {
        $this->notIsValueOfType["{$this->testName} IS NOT VALUE OF TYPE {$testedName}"] =
            $this->newIsValueOfTypeTestData($value, false);
        return $this;
    }


    /**
     * Builds isValueOfType() test data
     *
     * @return array
     */
    public function build(): array
    {
        if (count($this->isValueOfType) <= 1 || count($this->notIsValueOfType) <= 1) {
            throw new \DomainException("insufficient test cases for Type->isValueOfType()");
        }
        return array_merge($this->isValueOfType, $this->notIsValueOfType);
    }


    private function newIsValueOfTypeTestData($value, bool $expected): array
    {
        return [$this->type, $value, $expected];
    }
}
