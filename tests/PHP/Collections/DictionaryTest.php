<?php

use PHP\Collections\Dictionary;

/**
 * Dictionary Tests
 *
 * This only tests the editable portion of a Dictionary. See ReadOnlyDictionary
 * for the read accessors
 */
class DictionaryTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                           Iterator->clear()
    ***************************************************************************/
    
    /**
     * Test if clearing the dictionary has a count of zero
     */
    public function testDictionaryClearHasCountOfZero()
    {
        $dictionary = $this->getStringStringDictionary();
        $dictionary->clear();
        $this->assertTrue(
            ( 0 === $dictionary->count() ),
            "Dictionary->clear() returned a non-zero count"
        );
    }
    
    
    
    
    
    /***************************************************************************
    *                               UTILITIES
    ***************************************************************************/
    
    /**
     * Return sample Dictionary with string keys and string values
     *
     * @return Dictionary
     */
    public function getStringStringDictionary(): Dictionary
    {
        // For each entry, a-z, map it to the character at the other end
        $start = 97;
        $end   = 122;
        $dictionary = new Dictionary( 'string', 'string' );
        for ( $ascii = $start; $ascii <= $end; $ascii++ ) {
            $key   = chr( $ascii );
            $value = chr( ( $start + $end ) - $ascii );
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }
}
