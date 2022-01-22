<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Tests\Type;

use EvanWashkow\PHPLibraries\TypeInterface\InheritableTypeInterface;
use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * Builds test data for InheritableTypes.
 *
 * - A test for is(self) will be added on Builder creation.
 * - A test for is(clone self) will be added on Builder creation.
 */
final class InheritableTypeTestDataBuilder
{
    private string $testName;
    private InheritableTypeInterface $type;
    private array $is;
    private array $notIs;

    public function __construct(string $testName, InheritableTypeInterface $type)
    {
        $this->testName = $testName;
        $this->type = $type;
        $this->is = [];
        $this->notIs = [];

        // Add test for is(clone self)
        $this->is('self', $type);
        $this->is('clone', clone $type);
    }

    /**
     * Add a test for is().
     *
     * @param string        $testedName the name of the Type being tested
     * @param TypeInterface $type       the Type being tested
     */
    public function is(string $testedName, TypeInterface $type): self
    {
        $this->is["{$this->testName} IS {$testedName}"] =
            $this->newTestData($type, true);

        return $this;
    }

    /**
     * Add a test for !is().
     *
     * @param string        $testedName the name of the Type being tested
     * @param TypeInterface $type       the Type being tested
     */
    public function notIs(string $testedName, TypeInterface $type): self
    {
        $this->notIs["{$this->testName} IS NOT {$testedName}"] =
            $this->newTestData($type, false);

        return $this;
    }

    /**
     * Builds is() test data.
     */
    public function build(): array
    {
        if (0 == count($this->notIs)) {
            throw new \DomainException('insufficient test cases for Type->is()');
        }

        return array_merge($this->is, $this->notIs);
    }

    private function newTestData(TypeInterface $type, bool $expected): array
    {
        return [$this->type, $type, $expected];
    }
}
