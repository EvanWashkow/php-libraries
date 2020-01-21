<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\BitMapEnum;

class MaltypedIntegerEnum extends BitMapEnum
{

    const GOOD = 1;

    const BAD = '2';
}
