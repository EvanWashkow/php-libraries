<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IEquatable;

/**
 * Defines a basic object
 * 
 * @internal This does not implement ICloneable since not all Objects can be cloned. For  example, any type of File I/O
 * object should never be cloned since you cannot have two writers at the same time. ICloneable-ity must be determined
 * on a case-by-case basis.
 */
abstract class ObjectClass implements IEquatable
{

    /** @var null UNSET_HASH Value when the hash is unset */
    private const UNSET_HASH = null;

    /** @var ?ByteArray $hash This Object's hash */
    private $hash = self::UNSET_HASH;


    /**
     * Do some cleanup after clone
     * 
     * @internal Although ICloneable is not implemented on this class, it does not prevent someone from externally
     * cloning the object via `clone $object`.
     */
    public function __clone()
    {
        $this->hash = self::UNSET_HASH;
    }


    public function equals( $value ): bool
    {
        return $this === $value;
    }


    /**
     * @final The hash is only generated once. Successive calls to this function will always return the same hash.
     * (@see \PHP\Interfaces\IEquatable::hash()). To change the hash, override createHash().
     */
    final public function hash(): ByteArray
    {
        if ( self::UNSET_HASH === $this->hash ) {
            $this->hash = $this->createHash();
        }
        return $this->hash;
    }


    /**
     * Lazily-create this Object's hash sum.
     * 
     * This function will only be called once.
     * 
     * @see \PHP\ObjectClass::hash()
     * @return ByteArray
     */
    protected function createHash(): ByteArray
    {
        return new ByteArray( self::getNextRandomNumber() );
    }


    /**
     * Retrieve next random number to use as the hash
     * 
     * @return int
     */
    private static function getNextRandomNumber(): int
    {
        return rand( PHP_INT_MIN, PHP_INT_MAX );
    }
}