<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\Exceptions;

use PHP\Tests\Enums\TestEnumDefinitions\MaltypedIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\MaltypedStringEnum;
use PHP\Tests\Enums\TestEnumDefinitions\PrivateConstantEnum;
use PHP\Tests\Enums\TestEnumDefinitions\ProtectedConstantEnum;
use PHPUnit\Framework\TestCase;

/**
 * Ensures that all references to malformed enum child classes result in a MalformedEnumException
 */
class MalformedEnumExceptionTest extends TestCase
{

    /**
     * Test the construction / fetching of bad Enum definitions to ensure they throw exceptions
     * 
     * @expectedException \PHP\Enums\Exceptions\MalformedEnumException
     * @dataProvider getData()
     */
    public function test( \Closure $callback )
    {
        $callback();
    }


    public function getData(): array
    {
        return [

            // getConstants()
            'ProtectedConstantEnum::getConstants()' => [
                function() { ProtectedConstantEnum::getConstants(); }
            ],
            'PrivateConstantEnum::getConstants()' => [
                function() { PrivateConstantEnum::getConstants(); }
            ],
            'MaltypedIntegerEnum::getConstants()' => [
                function() { MaltypedIntegerEnum::getConstants(); }
            ],
            'MaltypedStringEnum::getConstants()' => [
                function() { MaltypedStringEnum::getConstants(); }
            ],

            // __construct()
            'new MaltypedIntegerEnum()' => [
                function() { new MaltypedIntegerEnum( MaltypedIntegerEnum::GOOD ); }
            ],
            'new MaltypedStringEnum()' => [
                function() { new MaltypedStringEnum( MaltypedStringEnum::GOOD ); }
            ]
        ];
    }
}