<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\StringEnumTest;

use PHP\Collections\Dictionary;
use PHP\Enums\StringEnum;

class GoodStringEnum extends StringEnum
{

    const A = 'a';

    const B = 'b';

    const C = 'c';


    public function setValue( $value ): string
    {
        return parent::setValue( $value );
    }


    public function getConstants(): Dictionary
    {
        return parent::getConstants();
    }
}
