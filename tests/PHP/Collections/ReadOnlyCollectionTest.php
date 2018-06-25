<?php

require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );

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
        foreach ( ReadOnlyDictionaryData::Get() as $dictionary ) {
            $this->assertInstanceOf(
                "PHP\\Collections\\Sequence",
                $dictionary->getKeys(),
                "Expected Sequence to be returned from ReadOnlyDictionary->getKeys()"
            );
        }
    }
}
