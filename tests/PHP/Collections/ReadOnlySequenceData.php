<?php

require_once( __DIR__ . '/SequenceData.php' );

use PHP\Collections\ReadOnlySequence;

/**
 * ReadOnlySequence test data
 */
final class ReadOnlySequenceData
{
    
    /**
     * Retrieve sample instances that implement read-only sequences
     * 
     * @return array
     */
    public static function Get(): array
    {
        $roSequences = [];
        foreach ( SequenceData::Get() as $type => $sequences ) {
            $roSequences[ $type ] = [];
            foreach ( $sequences as $sequence ) {
                $roSequences[ $type ][] = $sequence;
                $roSequences[ $type ][] = new ReadOnlySequence( $sequence );
            }
        }
        return $roSequences;
    }
    
    
    
    
    /***************************************************************************
    *                                     OLD
    ***************************************************************************/
    
    /**
    * Retrieve all test sequences
    *
    * @return array
    */
    public static function GetOld(): array
    {
        return array_merge(
            self::GetOldTyped(),
            self::GetOldMixed()
        );
    }
    
    
    /**
    * Retrieve sample Sequence with mixed types
    *
    * @return array
    */
    public static function GetOldMixed(): array
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
    public static function GetOldTyped(): array
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
     * Retrieves duplicate test data by appending the reverse with itself
     *
     * @return array
     */
    public static function GetDuplicates(): array
    {
        $duplicates = [];
        foreach ( SequenceData::GetDuplicates() as $type => $sequences ) {
            $duplicates[ $type ] = [];
            foreach ( $sequences as $sequence ) {
                $duplicates[ $type ][] = $sequence;
                $duplicates[ $type ][] = new ReadOnlySequence( $sequence );
            }
        }
        return $duplicates;
    }
    
    
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
