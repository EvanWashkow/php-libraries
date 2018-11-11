<?php
namespace PHP\Tests;

require_once( __DIR__ . '/../TestCase.php' );

/**
 * Defines a base test class for all collection test cases
 */
class CollectionsTestCase extends TestCase
{
    /**
     * Retrieve count of items in iterator
     *
     * @param \PHP\Collections\IIterator $iterator The iterator instance
     * @return int
     */
    final protected static function countElements( \PHP\Collections\IIterator $iterator ): int
    {
        $count = 0;
        foreach ( $iterator as $key => $value ) {
            $count++;
        }
        return $count;
    }
}
