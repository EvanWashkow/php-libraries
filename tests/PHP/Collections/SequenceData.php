<?php

use PHP\Collections\Sequence;

/**
 * Sequence test data
 */
class SequenceData
{
    
    /***************************************************************************
    *                                 MAIN
    ***************************************************************************/
    
    /**
     * Retrieve sample sequences
     *
     * @return array
     */
    public function Get(): array
    {
        return array_merge(
            self::GetEmpty(),
            self::GetNonEmpty()
        );
    }
    
    
    /**
     * Retrieve sample sequence data that has no entries
     *
     * @return array
     */
    public static function GetEmpty(): array
    {
        $sequences = [];
        foreach ( self::GetMixed() as $sequence ) {
            $sequence->clear();
            $sequences[] = $sequence;
        }
        return $sequences;
    }
    
    
    /**
     * Retrieve all non-empty test sequences
     *
     * @return array
     */
    public static function GetNonEmpty(): array
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
        return [
            self::getBool(),
            self::getEmptyString(),
            self::getString(),
            self::getObject()
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
    private static function getBool(): Sequence
    {
        $sequence = new Sequence( 'boolean' );
        $sequence->add( false );
        $sequence->add( true );
        return $sequence;
    }
    
    
    /**
    * Return an empty sample of a string sequence
    *
    * @return Sequence
    */
    private static function getEmptyString(): Sequence
    {
        return new Sequence( 'string' );
    }
    
    
    /**
     * Return sample Sequence with 0-1 => "0"-"1"
     *
     * @return Sequence
     */
    private static function getString(): Sequence
    {
        $sequence = self::getEmptyString();
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
