<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\Type\Type;

/**
 * Builds test data for Types.
 * 
 * - A test for is(self) will be added on Builder creation.
 */
final class TypeTestDataBuilder
{
    private string $testName;
    private Type $type;
    private array $is;
    private array $notIs;
    private array $isValueOfType;
    private array $notIsValueOfType;

    public function __construct(string $testName, Type $type)
    {
        $this->testName = $testName;
        $this->type = $type;
        $this->is = [];
        $this->notIs = [];
        $this->isValueOfType = [];
        $this->notIsValueOfType = [];

        // Add test for is(self)
        $this->is('self', $type);
    }


    /**
     * Add a test for is()
     *
     * @param string $testedName The name of the Type being tested.
     * @param Type $type The Type being tested.
     * @return self
     */
    public function is(string $testedName, Type $type): self
    {
        $this->is["{$this->testName} IS {$testedName}"] =
            $this->newIsTestData($type, true);
        return $this;
    }
    

    /**
     * Add a test for !is()
     *
     * @param string $testedName The name of the Type being tested.
     * @param Type $type The Type being tested.
     * @return self
     */
    public function notIs(string $testedName, Type $type): self
    {
        $this->is["{$this->testName} IS NOT {$testedName}"] =
            $this->newIsTestData($type, false);
        return $this;
    }


    /**
     * Builds is() test data
     *
     * @return array
     */
    public function buildIsTestData(): array
    {
        if (count($this->notIs) <= 1) {
            throw new \DomainException("insufficient test cases for Type->is()");
        }
        return array_merge($this->is, $this->notIs);
    }


    private function newIsTestData(Type $type, bool $expected): array
    {
        return [$this->type, $type, $expected];
    }
}
