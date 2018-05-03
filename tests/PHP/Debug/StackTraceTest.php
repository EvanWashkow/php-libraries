<?php

class StackTraceTest extends \PHPUnit\Framework\TestCase
{
    
    public function testGetReturnsAnArray()
    {
        $this->assertInternalType(
            'array',
            \PHP\Debug\StackTrace::Get(),
            'StackTrace::Get() didn\'t return an array'
        );
    }
}
