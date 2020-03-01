<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\InterfaceType;

class InterfaceTypeDetails implements IExpectedTypeDetails
{

    private $interfaceName;

    public function __construct( string $interfaceName )
    {
        $this->interfaceName = $interfaceName;
    }


    public function getTypeNames(): array
    {
        return [ $this->interfaceName ];
    }


    public function getTypeClassName(): string
    {
        return InterfaceType::class;
    }
}