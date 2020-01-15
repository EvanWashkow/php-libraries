<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\Exceptions;

use PHP\Tests\Enums\TestEnumDefinitions\BadIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\BadStringEnum;
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
            'new BadIntegerEnum()' => [
                function() { new BadIntegerEnum( BadIntegerEnum::ONE ); }
            ],
            'new BadStringEnum()' => [
                function() { new BadStringEnum( BadStringEnum::ONE ); }
            ]
        ];
    }
}