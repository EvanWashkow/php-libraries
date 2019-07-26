<?php
namespace PHP\Tests\ObjectClass;

use PHP\Interfaces\Cloneable;
use PHP\ObjectClass;

class Value extends ObjectClass implements Cloneable
{

    private $value;

    public function __construct( $value )
    {
        $this->value = $value;
    }


    public function clone(): Cloneable
    {
        return parent::clone();
    }
}