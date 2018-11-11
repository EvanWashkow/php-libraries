<?php
namespace PHP\Tests;

/**
 * Defines a base test case for all tests
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    
    /**
    * Get the class name of the object
    *
    * @param mixed $object The object instance
    * @return string
    */
    final protected static function getClassName( $object ): string
    {
        $name = get_class( $object );
        $name = explode( '\\', $name );
        return array_pop( $name );
    }
}
