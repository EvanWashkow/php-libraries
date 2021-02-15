<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\Enum;

class ProtectedConstantEnum extends Enum
{
    public const PUBLIC = 'public';

    protected const PROTECTED = 'protected';
}