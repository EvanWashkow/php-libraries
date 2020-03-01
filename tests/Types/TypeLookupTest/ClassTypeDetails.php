<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\ClassType;

class ClassTypeDetails extends InterfaceTypeDetails
{

    public function __construct( string $className )
    {
        parent::__construct( $className );
    }


    public function getTypeClassName(): string
    {
        return ClassType::class;
    }
}