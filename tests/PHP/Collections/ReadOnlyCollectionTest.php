<?php

require_once( __DIR__ . '/ReadOnlyCollectionData.php' );

/**
 * Test ReadOnlyCollection methods
 */
class ReadOnlyCollectionTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                       ReadOnlyCollection->getKeys()
    ***************************************************************************/

    /**
     * Does getKeys() return a sequence?
     */
    public function testGetKeysReturnsSequence()
    {
        foreach ( ReadOnlyCollectionData::Get() as $dictionary ) {
            $this->assertInstanceOf(
                "PHP\\Collections\\Sequence",
                $dictionary->getKeys(),
                "Expected Sequence to be returned from ReadOnlyDictionary->getKeys()"
            );
        }
    }
}
