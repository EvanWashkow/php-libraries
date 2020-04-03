<?php
namespace PHP\Collections;

/**
 * Defines a key-value pair that can be retrieved
 */
class KeyValuePair
{

    /** @var mixed $key The key */
    private $key;


    /**
     * Create a new key-value pair
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     **/
    public function __construct( $key, $value )
    {
        $this->key = $key;
    }


    /**
     * Retrieve the key
     * 
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }
}