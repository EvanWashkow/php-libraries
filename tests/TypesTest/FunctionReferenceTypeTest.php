<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;

/**
 * Tests the \PHP\Types\FunctionReferenceType functionality
 */
class FunctionReferenceTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                 FunctionReferenceType->getFunctionName()
    ***************************************************************************/


    /**
     * Ensure FunctionReferenceType->getFunctionName() returns the function name
     **/
    public function testGetFunctionNameReturnsName()
    {
        $this->assertEquals(
            'substr',
            Types::GetByName( 'substr' )->getFunctionName(),
            'Expected FunctionReferenceType->getFunctionName() to return the function name'
        );
    }
}