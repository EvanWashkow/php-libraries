<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\ClassType;
use PHP\Types\Models\InterfaceType;

class ClassTypeDetails extends InterfaceTypeDetails
{

    public function __construct( string $className )
    {
        parent::__construct( $className );
    }


    public function getTypeNames(): array
    {
        return [ ClassType::class, InterfaceType::class ];
    }
}