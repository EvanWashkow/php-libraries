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
        foreach ( SequenceData::GetMixed() as $sequence ) {
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
        foreach ( SequenceData::GetTyped() as $sequence ) {
            $sequences[] = new ReadOnlySequence( $sequence );
            $sequences[] = $sequence;
        }
        return $sequences;
    }
}
