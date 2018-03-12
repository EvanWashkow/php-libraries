<?php
namespace PHP\Collections;

use PHP\Collections\Sequence\iSequence;

/**
 * Defines a mutable, ordered set of indexed values
 *
 * This would have been named "List" had that not been reserved by PHP
 */
class Sequence extends \PHP\Object implements iSequence
{
    
    /**
     * The dictionary instance
     *
     * @var Dictionary
     */
    private $dictionary;
    
    
    public function __construct( string $type = '' )
    {
        $this->dictionary = new Dictionary( 'integer', $type );
    }
    
    
    public function ConvertToArray(): array
    {
        return $this->dictionary->ConvertToArray();
    }
    
    public function Count(): int
    {
        return $this->dictionary->Count();
    }
    
    public function Get( $index, $defaultValue = null )
    {
        return $this->dictionary->Get( $index, $defaultValue );
    }
    
    public function HasIndex( $index ): bool
    {
        return $this->dictionary->HasIndex( $index );
    }
    
    public function Loop( callable $function, &...$args )
    {
        $parameters = array_merge( [ $function ], $args );
        return call_user_func_array( [ $this->dictionary, 'Loop' ], $parameters );
    }
}
