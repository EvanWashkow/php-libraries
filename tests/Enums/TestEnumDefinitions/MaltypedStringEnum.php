<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\StringEnum;

class MaltypedStringEnum extends StringEnum
{

    const GOOD = '1';

    const BAD = 2;
}
