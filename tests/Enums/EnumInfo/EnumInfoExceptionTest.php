<?php
declare(strict_types=1);

namespace PHP\Tests\Enums\EnumInfo;

use PHP\Enums\EnumInfo\EnumInfoLookup;
use PHP\Tests\TestCase;

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
    public function testDomainExceptionOnBadType( \Closure $function ): void
    {
        $function();
    }


    public function getDomainExceptionData(): array
    {
        $enumInfoLookup = new EnumInfoLookup();

        return [
            'EnumInfoLookup->get( <non-class> )' => function() use ( $enumInfoLookup ) {
                $enumInfoLookup->get( 'int' );
            }
        ];
    }
}