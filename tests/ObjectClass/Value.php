<?php
namespace PHP\Tests\ObjectClass;

use PHP\ObjectClass;

class Value extends ObjectClass
{

    private $value;

    public function __construct( $value )
    {
        $this->value = $value;
    }
}