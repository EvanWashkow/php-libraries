<?php
namespace PHP\Collections;

/**
 * Defines a key-value pair that can be retrieved
 */
class KeyValuePair
{

    /** @var mixed $key The key */
    private $key;

    /** @var mixed $value The value */
    private $value;


    /**
     * Create a new key-value pair
     *
     * @param mixed $key   The key
     * @param mixed $value The value
     **/
    public function __construct( $key, $value )
    {
        $this->key   = $key;
        $this->value = $value;
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


    /**
     * Retrieve the value
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}