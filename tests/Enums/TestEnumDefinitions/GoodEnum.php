<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\Enum;

class GoodEnum extends Enum
{

    const ONE_INTEGER = 1;

    const ONE_STRING = '1';

    const ARRAY = [ 1, 2, 3 ];


    /**
     * Converts this integer array to a string array
     */
    final public static function GetStringArray(): array
    {
        $stringArray = [];
        foreach ( GoodEnum::ARRAY as $value ) {
            $stringArray[] = "$value";
        }
        return $stringArray;
    }
}
