<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\EnumTest;

use PHP\Enums\Enum;

class MixedEnum extends Enum
{

    const STRING = 'abc';

    const NUMBERS = 123;

    const ARRAY = [ 1, 2, 3 ];
}
