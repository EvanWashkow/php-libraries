<?php

require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );

/**
 * Dictionary Tests
 *
 * This only tests the editable portion of a Dictionary. See ReadOnlyDictionary
 * for the read accessors
 */
class ReadOnlyDictionaryTest extends \PHPUnit\Framework\TestCase
{
    
    /**
     * Cloning a dictionary should clone all the entries
     */
    public function testCloneCopiesAllEntries()
    {
        foreach ( ReadOnlyDictionaryData::Get() as $dictionary ) {
            $clone = $dictionary->clone();
            $clone->loop( function( $key, $value ) use ( $dictionary ) {
                $this->assertTrue(
                    $dictionary->hasKey( $key ),
                    "Dictionary->clone() entry does not have the same key"
                );
                $this->assertEquals(
                    $value,
                    $dictionary->get( $key ),
                    "Dictionary->clone() entry does not have the same value"
                );
            });
        }
    }
}
