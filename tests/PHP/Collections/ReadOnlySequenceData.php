<?php

require_once( __DIR__ . '/SequenceData.php' );

use PHP\Collections\ReadOnlySequence;

/**
 * ReadOnlySequence test data
 */
final class ReadOnlySequenceData
{
    
    /**
    * Retrieve all test sequences
    *
    * @return array
    */
    public static function Get(): array
    {
        return array_merge(
            self::GetTyped(),
            self::GetMixed()
        );
    }
    
    
    /**
    * Retrieve sample Sequence with mixed types
    *
    * @return array
    */
    public static function GetMixed(): array
    {
        $sequences = [];
        foreach ( SequenceData::GetOldMixed() as $sequence ) {
            $sequences[] = new ReadOnlySequence( $sequence );
            $sequences[] = $sequence;
        }
        return $sequences;
    }
    
    
    /**
     * Retrieve all test typed sequences
     *
     * @return array
     */
    public static function GetTyped(): array
    {
        $sequences = [];
        foreach ( SequenceData::GetOldTyped() as $sequence ) {
            $sequences[] = new ReadOnlySequence( $sequence );
            $sequences[] = $sequence;
        }
        return $sequences;
    }
    
    
    
    
    /***************************************************************************
    *                                   DUPLICATES
    ***************************************************************************/
    
    /**
     * Retrieves test data with duplicated strings
     *
     * @return array
     */
    public static function GetStringDuplicates(): array
    {
        $sequences = [];
        foreach ( SequenceData::GetStringDuplicates() as $sequence ) {
            $sequences[] = $sequence;
            $sequences[] = new ReadOnlySequence( $sequence );
        }
        return $sequences;
    }
}
