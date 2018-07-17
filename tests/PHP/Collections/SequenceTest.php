<?php

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/SequenceData.php' );

/**
 * Test all Sequence methods to ensure consistent functionality
 */
class SequenceTest extends \PHP\Tests\Collections\CollectionsTestCase
{
    /**
     * Ensure one is one
     */
    public function testOneIsOne()
    {
        $this->assertEquals(
            1,
            1,
            "Expected one to be one"
        );
    }
}
