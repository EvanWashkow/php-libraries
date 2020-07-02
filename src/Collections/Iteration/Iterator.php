<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iteration;

/**
 * Traverses an IIterable item in a foreach() loop, retrieving that item's key and value.
 */
abstract class Iterator implements \Iterator
{




    /*******************************************************************************************************************
    *                                                 ABSTRACT METHODS
    *******************************************************************************************************************/

    /**
     * @internal Set the starting position here so that any calls to this method will start the loop at the beginning.
     */
    abstract public function rewind(): void;


    /**
     * Determines if there is a current item (there exists a current key and value)
     * 
     * @return bool
     */
    abstract public function hasCurrent(): bool;


    /**
     * Retrieve the key for the current item
     * 
     * @return scalar
     * @throws \OutOfBoundsException If the current position is invalid
     */
    abstract public function getKey();


    /**
     * Retrieve the value for the current item
     * 
     * @return mixed
     * @throws \OutOfBoundsException If the current position is invalid
     */
    abstract public function getValue();


    /**
     * Proceed to the next item (regardless if it exists or not)
     * 
     * @internal This is one of the inherit design flaws of PHP: you must increment to an invalid position and then
     * report it as such. This is why hasCurrent() was added for validating the current position, why getKey() and
     * getValue() throw \OutOfBoundExceptions, and why this interim class was added. Unfortunately, this design problem
     * cannot be solved in a child implementation.
     * 
     * @return void
     */
    abstract public function goToNext(): void;




    /*******************************************************************************************************************
    *                                                  FINAL METHODS
    *******************************************************************************************************************/


    /**
     * @internal Final. This method's implementation is determined by hasCurrent() and getValue().
     */
    final public function current()
    {
        return $this->hasCurrent() ? $this->getValue() : null;
    }


    /**
     * @internal Final. This method's implementation is determined by hasCurrent() and getKey().
     */
    final public function key()
    {
        return $this->hasCurrent() ? $this->getKey() : null;
    }


    /**
     * @internal Final. This method's implementation is determined by goToNext().
     */
    final public function next(): void
    {
        $this->goToNext();
    }


    /**
     * @internal Final. This method's implementation is determined by hasCurrent().
     */
    final public function valid(): bool
    {
        return $this->hasCurrent();
    }
}