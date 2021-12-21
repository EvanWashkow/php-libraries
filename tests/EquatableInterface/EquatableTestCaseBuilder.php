<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\EquatableInterface;

use EvanWashkow\PHPLibraries\EquatableInterface;

/**
 * Builds EquatableTestCases.
 */
final class EquatableTestCaseBuilder
{
    private string $testNamePrefix;

    private EquatableInterface $equatable;

    /** @var array<EquatableTestCase> */
    private array $equals;

    /** @var array<EquatableTestCase> */
    private array $notEquals;

    /**
     * Creates a new EquatableTestCaseBuilder.
     *
     * @param string $testNamePrefix The test name prefix.
     * @param EquatableInterface $equatable The EquatableInterface instance.
     */
    public function __construct(string $testNamePrefix, EquatableInterface $equatable)
    {
        $this->testNamePrefix = $testNamePrefix;
        $this->equatable = $equatable;
        $this->equals = [];
        $this->notEquals = [];
    }


    /**
     * Add test for value that should be equal.
     *
     * @param string $testNameSuffix The test name suffix.
     * @param mixed $value The value to test.
     * @return self
     */
    public function equals(string $testNameSuffix, $value): self
    {
        $testName = "{$this->testNamePrefix} SHOULD EQUAL {$testNameSuffix}";
        $this->equals[$testName] = new EquatableTestCase($testName, $this->equatable, $value, true);
        return $this;
    }


    /**
     * Add test for value that should not be equal.
     *
     * @param string $testNameSuffix The test name suffix.
     * @param mixed $value The value to test.
     * @return self
     */
    public function notEquals(string $testNameSuffix, $value): self
    {
        $testName = "{$this->testNamePrefix} SHOULD NOT EQUAL {$testNameSuffix}";
        $this->notEquals[$testName] = new EquatableTestCase($testName, $this->equatable, $value, false);
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
}
