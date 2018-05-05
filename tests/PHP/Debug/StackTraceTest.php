<?php

/**
 * StackTrace tests
 */
class StackTraceTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                                  Get()
    ***************************************************************************/
    
    /**
     * Does Get() return an array?
     */
    public function testGetReturnsAnArray()
    {
        $this->assertInternalType(
            'array',
            \PHP\Debug\StackTrace::Get(),
            'StackTrace::Get() didn\'t return an array, as expected'
        );
    }
    
    
    /**
     * Ensure Get() array is not empty
     */
    public function testGetReturnsNonEmptyArray()
    {
        $this->assertTrue(
            ( 0 !== count( \PHP\Debug\StackTrace::Get() )),
            'StackTrace::Get() returned an empty array. There should be some entries.'
        );
    }
    
    
    
    
    /***************************************************************************
    *                                 ToString()
    ***************************************************************************/
    
    /**
     * Does ToString() return a string?
     */
    public function testToStringReturnsString()
    {
        $this->assertInternalType(
            'string',
            \PHP\Debug\StackTrace::ToString(),
            'StackTrace::ToString() didn\'t return a string, as expected'
        );
    }
}
