<?php

use PHP\Collections\Sequence;

require_once( __DIR__ . '/CollectionTestData.php' );

/**
 * Sequence test data
 */
final class SequenceData
{
    
    /**
     * Retrieve test instances, indexed by type
     *
     * @return array
     */
    public static function Get(): array
    {
        $instances = [];
        foreach ( CollectionTestData::Get() as $type => $values ) {
            $sequence = new Sequence( $type );
            foreach ( $values as $value ) {
                $sequence->add( $value );
            }
            
            $instances[ $type ]   = [];
            $instances[ $type ][] = new Sequence( $type );
            $instances[ $type ][] = $sequence;
        }
        return $instances;
    }
    
    
    
    
    /***************************************************************************
    *                                  OLD
    ***************************************************************************/
    
    
    /**
     * Retrieve old test data
     *
     * @return array
     */
    public static function GetOld(): array
    {
        $sequences = [];
        foreach ( SequenceData::Get() as $type => $_sequences ) {
            foreach ( $_sequences as $sequence ) {
                $sequences[] = $sequence;
            }
        }
        return $sequences;
    }
    
    
    /**
     * Retrieve old typed data
     * 
     * @return array
     */
    public static function GetOldTyped()
    {
        $sequences = [];
        foreach ( SequenceData::Get() as $type => $_sequences ) {
            if ( in_array( $type, [ '', 'integer' ] )) {
                continue;
            }
            foreach ( $_sequences as $sequence ) {
                $sequences[] = $sequence;
            }
        }
        return $sequences;
    }
    
    
    /**
     * Retrieve old mixed data
     * 
     * @return array
     */
    public static function GetOldMixed()
    {
        $sequences = [];
        foreach ( SequenceData::Get() as $type => $_sequences ) {
            if ( '' !== $type ) {
                continue;
            }
            foreach ( $_sequences as $sequence ) {
                $sequences[] = $sequence;
            }
        }
        return $sequences;
    }
    
    
    
    
    /***************************************************************************
    *                                 DUPLICATES
    ***************************************************************************/
    
    
    /**
     * Retrieves test data with duplicated strings
     *
     * @return array
     */
    public static function GetStringDuplicates(): array
    {
        $sequence = new Sequence( 'string' );
        $sequence->add( '0' );
        $sequence->add( '1' );
        $sequence->add( '1' );
        $sequence->add( '0' );
        $sequence->add( '0' );
        $sequence->add( '1' );
        return [
            $sequence
        ];
    }
}
