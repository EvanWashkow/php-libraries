<?php
declare(strict_types=1);

namespace PHP\Tests\Enums\EnumInfo;

use PHP\Enums\EnumInfo\EnumInfo;
use PHP\Enums\EnumInfo\EnumInfoLookup;
use PHP\ObjectClass;
use PHP\Tests\TestCase;
use PHP\Types;

/**
 * EnumInfo classes should throw exceptions on bad type arguments.
 * 
 * This is different than the BadEnumDefinitionTest. This only tests bad Enum Info type arguments, only.
 */
class EnumInfoExceptionTest extends TestCase
{


    /**
     * EnumInfo should throw DomainExceptions when given a non-Enum class
     * 
     * @expectedException \DomainException
     * @dataProvider getDomainExceptionData()
     */
    public function testDomainExceptionOnWrongType( \Closure $function ): void
    {
        $function();
    }


    public function getDomainExceptionData(): array
    {
        $enumInfoLookup = new EnumInfoLookup();

        return [
            'EnumInfoLookup->get( int )' => [
                function() use ( $enumInfoLookup ) { $enumInfoLookup->get( 'int' ); }
            ],
            'EnumInfoLookup->get( ObjectClass )' => [
                function() use ( $enumInfoLookup ) { $enumInfoLookup->get( ObjectClass::class ); }
            ],
            'new EnumInfo( ObjectClass )' => [
                function() { new EnumInfo( Types::GetByName( ObjectClass::class ) ); }
            ]
        ];
    }
}