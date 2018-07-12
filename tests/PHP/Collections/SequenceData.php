<?php

use PHP\Collections\Sequence;

/**
 * Sequence test data
 */
class SequenceData
{
    
    /**
     * Retrieve all non-empty test sequences
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
        $sequence = new Sequence();
        foreach ( self::GetTyped() as $typedSequence ) {
            $typedSequence->loop( function( $key, $value ) use ( &$sequence ) {
                $sequence->add( $value );
            });
        }
        return [
            $sequence
        ];
    }
    
    
    /**
     * Retrieve all test typed sequences
     *
     * IMPORTANT: Key and value types must be different. It is useful to swap
     * key / values as parameters to test type constraints. It is best to define
     * similar entries that PHP usually chokes on, such as "1" => 1
     *
     * @return array
     */
    public static function GetTyped(): array
    {
        $empty = self::getString();
        $empty->clear();
        return [
            $empty,
            self::getBool(),
            self::getString(),
            self::getObject()
        ];
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
    
    
    /***************************************************************************
    *                                   TYPED
    ***************************************************************************/
    
    /**
     * Return sample Sequence with 0, 1 => false, true
     *
     * @return Sequence
     */
    public static function getBool(): Sequence
    {
        $sequence = new Sequence( 'boolean' );
        $sequence->add( false );
        $sequence->add( true );
        return $sequence;
    }
    
    
    /**
     * Return sample Sequence with 0-1 => "0"-"1"
     *
     * @return Sequence
     */
    private static function getString(): Sequence
    {
        $sequence = new Sequence( 'string' );
        for ( $i = 0; $i <= 1; $i++ ) {
            $sequence->add( (string) $i );
        }
        return $sequence;
    }
    
    
    /**
     * Return sample Sequence with 0 => new stdClass()
     *
     * @return Sequence
     */
    private static function getObject(): Sequence
    {
        $sequence = new Sequence( 'stdClass' );
        $sequence->add( new stdClass() );
        return $sequence;
    }
}
