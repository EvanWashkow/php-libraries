<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\EquatableInterface;

use EvanWashkow\PHPLibraries\EquatableInterface;

/**
 * Builds EquatableTestCases.
 * 
 * - A test for the EquatableInterface to equal itself will be added on Builder creation.
 */
final class EquatableTestDataBuilder
{
    private string $moduleName;

    private EquatableInterface $equatable;

    private array $equals;

    private array $notEquals;

    /**
     * Creates a new EquatableTestDataBuilder.
     *
     * @param string $moduleName The name of the module under.
     * @param EquatableInterface $equatable The EquatableInterface instance.
     */
    public function __construct(string $moduleName, EquatableInterface $equatable)
    {
        $this->moduleName = $moduleName;
        $this->equatable = $equatable;
        $this->equals = [];
        $this->notEquals = [];

        // The object must be equivalent to itself.
        $this->equals('self', $equatable);
    }


    /**
     * Add test for value that should be equal.
     *
     * @param string $valueName The name of the value.
     * @param mixed $value The value to test.
     * @return self
     */
    public function equals(string $valueName, $value): self
    {
        $this->equals["{$this->moduleName} SHOULD EQUAL {$valueName}"] =
            $this->newTestCase($value, true);
        return $this;
    }


    /**
     * Add test for value that should not be equal.
     *
     * @param string $valueName The name of the value.
     * @param mixed $value The value to test.
     * @return self
     */
    public function notEquals(string $valueName, $value): self
    {
        $this->notEquals["{$this->moduleName} SHOULD NOT EQUAL {$valueName}"] =
            $this->newTestCase($value, false);
        return $this;
    }


    /**
     * Builds a set of EquatableTestCases.
     *
     * @return array<EquatableTestCase>
     */
    public function build(): array
    {
        if (count($this->equals) == 0 || count($this->notEquals) <= 1)
        {
            throw new \DomainException("insufficient test cases for EquatableInterface");
        }
        return array_merge($this->equals, $this->notEquals);
    }


    /**
     * Creates a new test case.
     *
     * @param mixed $value The value to test.
     * @param boolean $expected The expected result.
     * @return array
     */
    private function newTestCase($value, bool $expected): array
    {
        return [$this->equatable, $value, $expected];
    }
}
