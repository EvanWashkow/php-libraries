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


    /**
     * Determine if this object equals another object
     * 
     * @internal Can't use "==" in any fashion. "==" implicitly converts
     * property types if they aren't typed, which gives the wrong result.
     * For example, Value->value = '1' and Value->value = 1 are considered equal
     * (==) to eachother, when they are not.
     * 
     * @internal Interesting to note, "===" returns "true" for two different
     * array instances which have the same values.
     * 
     * @param mixed $value The value to compare this Object to
     * 
     * @return bool
     */
    public function equals( $value ): bool
    {
        // Compare instances
        $isEqual = $this === $value;

        // If not equals, compare individual object properties
        if ( !$isEqual )
        {
            // Is $value derived from $this class? If not, false.
            $class = new ReflectionClass( $this );
            if ( is_a( $value, $class->getName() ) )
            {
                // For each of this class' properties, compare the two object's
                // values for those properties.
                $properties = $class->getProperties();
                foreach ( $properties as $property ) {
                    $property->setAccessible( true );
                    $thisPropValue  = $property->getValue( $this );
                    $valuePropValue = $property->getValue( $value );
                    $isEqual        = $thisPropValue === $valuePropValue;
                    if ( !$isEqual ) {
                        break;
                    }
                }
            }
        }

        return $isEqual;
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