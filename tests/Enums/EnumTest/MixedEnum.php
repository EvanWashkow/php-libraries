<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\EnumTest;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;

class MixedEnum extends Enum
{

    const STRING = 'abc';

    const NUMBERS = 123;

    const ARRAY = [ 1, 2, 3 ];


    public function setValue( $value )
    {
        return parent::setValue( $value );
    }


    public function getConstants(): Dictionary
    {
        return parent::getConstants();
    }
}
