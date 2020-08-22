<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IEquatable;
use ReflectionClass;

/**
 * Defines a basic object
 * 
 * @internal This does not implement ICloneable since not all Objects can be cloned. For  example, any type of File I/O
 * object should never be cloned since you cannot have two writers at the same time. ICloneable-ity must be determined
 * on a case-by-case basis.
 */
abstract class ObjectClass implements IEquatable
{

    /** @var ?ByteArray $hash This Object's hash */
    private $hash;


    /**
     * Create a new Object Class
     */
    public function __construct()
    {
        $this->invalidateHash();
    }


    /**
     * Do some cleanup after clone
     * 
     * @internal Although ICloneable is not implemented on this class, it does not prevent someone from calling
     * `clone $object`.
     */
    public function __clone()
    {
        $this->invalidateHash();
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
        if ( null === $this->hash ) {
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
     * Invalidate the hash
     * 
     * This should only be called in very few, and very specific situations when the hash becomes invalid. Such as after
     * an object has been cloned.
     * 
     * @return void
     */
    private function invalidateHash(): void
    {
        $this->hash = null;
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