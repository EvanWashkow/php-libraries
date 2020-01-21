<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\BitMapEnum;

class MaltypedBitMapEnum extends BitMapEnum
{

    const GOOD = 1;

    const BAD = '2';
}
