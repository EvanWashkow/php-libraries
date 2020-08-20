<?php
declare( strict_types = 1 );

namespace PHP\Hashing\Decorators;

/**
 * Customizes how a hash is generated for **any** given value.
 * 
 * Allows the user to customize how a hash is generated for any given value by chaining together a series of
 * instructions using the Decorator Pattern.
 */
abstract class HashDecorator
{

    /** @var ?HashDecorator $nextDecorator The next Hash Decorator to call in the series */
    private $nextDecorator;


    /**
     * Create a new Hash Decorator
     * 
     * @param ?HashDecorator $nextDecorator The next Hash Decorator to call in the series
     */
    public function __construct( ?HashDecorator $nextDecorator )
    {
        $this->nextDecorator = $nextDecorator;
    }
}