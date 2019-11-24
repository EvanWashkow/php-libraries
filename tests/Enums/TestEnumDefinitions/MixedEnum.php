<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;

class MixedEnum extends Enum
{

    const STRING = '123';

    const NUMBERS = 234;

    const ARRAY = [ 1, 2, 3 ];


    /**
     * Converts this integer array to a string array
     */
    final public static function GetStringArray(): array
    {
        $stringArray = [];
        foreach ( MixedEnum::ARRAY as $value ) {
            $stringArray[] = "$value";
        }
        return $stringArray;
    }
}
