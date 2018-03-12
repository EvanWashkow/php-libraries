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
}
