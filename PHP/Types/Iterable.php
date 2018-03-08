<?php
namespace PHP\Types;

/**
 * Defines a set of entries, with arbitrary indexes, that can be iterated over
 */
class Iterable
{
    
    /**
     * The indexed set of entries
     *
     * @var array
     */
    protected $entries;
    
    
    /**
     * Creates a new Iterable instance for the entries
     *
     * @param array $entries The indexed set of entries
     */
    public function __construct( array $entries )
    {
        $this->entries = $entries;
    }
}
