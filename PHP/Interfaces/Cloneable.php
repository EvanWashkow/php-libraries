<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

/**
 * Describes any object that can be duplicated
 * 
 * @internal All objects can be cloned via "clone $x", however, the syntax here
 * is a more object-oriented syntax. Additionally, the magic "__clone" method
 * is called after cloning, but this is called before.
 */
interface Cloneable
{

    /**
     * Make a copy of this object
     * 
     * @return Clonable
     */
    public function clone(): Cloneable;
}