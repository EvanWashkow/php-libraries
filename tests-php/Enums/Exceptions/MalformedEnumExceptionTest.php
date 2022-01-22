<?php

declare(strict_types=1);

namespace PHP\Tests\Enums\Exceptions;

use PHP\Enums\Exceptions\MalformedEnumException;
use PHP\Tests\Enums\TestEnumDefinitions\MaltypedBitMapEnum;
use PHP\Tests\Enums\TestEnumDefinitions\MaltypedIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\MaltypedStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\PrivateConstantEnum;
use PHP\Tests\Enums\TestEnumDefinitions\ProtectedConstantEnum;
use PHPUnit\Framework\TestCase;

/**
 * Ensures that all references to malformed enum child classes result in a MalformedEnumException.
 *
 * @internal
 * @coversNothing
 */
class MalformedEnumExceptionTest extends TestCase
{
    /**
     * Test the construction / fetching of bad Enum definitions to ensure they throw exceptions.
     *
     * @dataProvider getData()
     */
    public function test(\Closure $callback)
    {
        $this->expectException(MalformedEnumException::class);
        $callback();
    }

    public function getData(): array
    {
        return [
            // getConstants()
            'MaltypedIntegerEnum::getConstants()' => [
                function () {
                    MaltypedIntegerEnum::getConstants();
                },
            ],
            'MaltypedStringEnum::getConstants()' => [
                function () {
                    MaltypedStringEnum::getConstants();
                },
            ],
            'MaltypedBitMapEnum::getConstants()' => [
                function () {
                    MaltypedBitMapEnum::getConstants();
                },
            ],
            'ProtectedConstantEnum::getConstants()' => [
                function () {
                    ProtectedConstantEnum::getConstants();
                },
            ],
            'PrivateConstantEnum::getConstants()' => [
                function () {
                    PrivateConstantEnum::getConstants();
                },
            ],

            // __construct()
            'new MaltypedIntegerEnum()' => [
                function () {
                    new MaltypedIntegerEnum(MaltypedIntegerEnum::GOOD);
                },
            ],
            'new MaltypedStringEnum()' => [
                function () {
                    new MaltypedStringEnum(MaltypedStringEnum::GOOD);
                },
            ],
            'new MaltypedBitMapEnum()' => [
                function () {
                    new MaltypedBitMapEnum(MaltypedBitMapEnum::GOOD);
                },
            ],
        ];
    }
}
