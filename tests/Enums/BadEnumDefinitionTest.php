<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums;

use PHP\Tests\Enums\TestEnumDefinitions\BadIntegerEnum;
use PHP\Tests\Enums\TestEnumDefinitions\BadStringEnum;
use PHPUnit\Framework\TestCase;

/**
 * Tests the construction / fetching of bad Enum definitions to ensure they throw exceptions
 */
class BadEnumDefinitionTest extends TestCase
{

    /**
     * Test the construction / fetching of bad Enum definitions to ensure they throw exceptions
     * 
     * @expectedException \DomainException
     * @dataProvider getData()
     */
    public function test( \Closure $callback )
    {
        $callback();
    }


    public function getData(): array
    {
        return [
            'BadIntegerEnum' => [
                function() { new BadIntegerEnum( BadIntegerEnum::NUMBERS ); }
            ],
            'BadStringEnum' => [
                function() { new BadStringEnum( BadStringEnum::A ); }
            ],
        ];
    }
}