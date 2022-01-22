<?php

declare(strict_types=1);

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iterators\SequenceIterator;
use PHP\Collections\Sequence;
use PHPUnit\Framework\TestCase;

/**
 * Tests SequenceIterator
 */
class SequenceIteratorTest extends TestCase
{
    /*******************************************************************************************************************
    *                                                      INHERITANCE
    *******************************************************************************************************************/


    /**
     * Ensure SequenceIterator is an instance of a ArrayableIterator
     */
    public function testIsArrayableIterator()
    {
        $this->assertInstanceOf(
            ArrayableIterator::class,
            new SequenceIterator(new Sequence('int')),
            'SequenceIterator is not an ArrayableIterator instance.'
        );
    }




    /*******************************************************************************************************************
    *                                                     __construct()
    *******************************************************************************************************************/


    /**
     * Test __construct() correctly sets the starting index
     *
     * @dataProvider getConstructStartingIndexTestData
     */
    public function testConstructStartingIndex(Sequence $sequence)
    {
        $this->assertEquals(
            $sequence->getFirstKey(),
            ( new SequenceIterator($sequence) )->getKey(),
            'SequenceIterator->getKey() did not return the Sequence->getFirstKey().'
        );
    }

    public function getConstructStartingIndexTestData()
    {
        return [
            'Sequence->getFirstKey() === -2' => [
                (function () {
                    $sequence = $this->createMock(Sequence::class);
                    $sequence->method('getFirstKey')->willReturn(-2);
                    return $sequence;
                })()
            ],
            'Sequence->getFirstKey() === 0' => [
                new Sequence('*')
            ],
            'Sequence->getFirstKey() === 3' => [
                (function () {
                    $sequence = $this->createMock(Sequence::class);
                    $sequence->method('getFirstKey')->willReturn(3);
                    return $sequence;
                })()
            ]
        ];
    }




    /*******************************************************************************************************************
    *                                                       getValue()
    *******************************************************************************************************************/

    /**
     * Test getValue() return key
     *
     * @dataProvider getIterators
     */
    public function testGetValue(SequenceIterator $iterator, bool $hasCurrent, int $key, ?int $value)
    {
        if (null === $value) {
            $this->expectException(\OutOfBoundsException::class);
            $iterator->getValue();
        } else {
            $this->assertEquals(
                $value,
                $iterator->getValue(),
                'SequenceIterator->getValue() did not return the expected value.'
            );
        }
    }




    /*******************************************************************************************************************
    *                                                       getKey()
    *******************************************************************************************************************/

    /**
     * Test getKey() return key
     *
     * @dataProvider getIterators
     */
    public function testGetKey(SequenceIterator $iterator, bool $hasCurrent, int $key, ?int $value)
    {
        $this->assertEquals(
            $key,
            $iterator->getKey(),
            'SequenceIterator->getKey() did not return the expected value.'
        );
    }




    /*******************************************************************************************************************
    *                                                      hasCurrent()
    *******************************************************************************************************************/

    /**
     * Test hasCurrent() return value
     *
     * @dataProvider getIterators
     */
    public function testHasCurrent(SequenceIterator $iterator, bool $hasCurrent, int $key, ?int $value)
    {
        $this->assertEquals(
            $hasCurrent,
            $iterator->hasCurrent(),
            'SequenceIterator->hasCurrent() did not return the expected value.'
        );
    }




    /*******************************************************************************************************************
    *                                                   SHARED DATA PROVIDERS
    *******************************************************************************************************************/


    /**
     * Retrieve sample SequenceIterator test data
     *
     * @return array
     */
    public function getIterators(): array
    {
        // Zero-based index Sequences
        $zeroBased  = new Sequence('int', [ 1, 2, 3 ]);

        // Three-based index Sequences
        $threeBased = $this->getMockBuilder(Sequence::class)
            ->setConstructorArgs([ 'int' ])
            ->setMethods([ 'getFirstKey' ])
            ->getMock();
        $threeBased->method('getFirstKey')->willReturn(3);
        $threeBased->set(3, 1);
        $threeBased->set(4, 2);
        $threeBased->set(5, 2);

        return [

            /**
             * Example SequenceIterator with no entries
             */
            'SequenceIterator([]), zero-based index' => [
                new SequenceIterator(new Sequence('int')),      // SequenceIterator
                false,                                              // ->hasCurrent()
                0,                                                  // ->getKey()
                null                                                // ->getValue()
            ],


            /**
             * Zero-based indexed Sequences
             */
            'SequenceIterator( zeroBased )' => [
                new SequenceIterator($zeroBased),
                true,
                0,
                1
            ],
            'SequenceIterator( zeroBased )->goToNext()' => [
                (function () use ($zeroBased) {
                    $iterator = new SequenceIterator($zeroBased);
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                1,
                2
            ],
            'SequenceIterator( zeroBased )->goToNext()->goToNext()->goToNext()' => [
                (function () use ($zeroBased) {
                    $iterator = new SequenceIterator($zeroBased);
                    $iterator->goToNext();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                3,
                null
            ],


            /**
             * Three-based indexed Sequences
             */
            'SequenceIterator( threeBased )' => [
                new SequenceIterator($threeBased),
                true,
                3,
                1
            ],
            'SequenceIterator( threeBased )->goToNext()' => [
                (function () use ($threeBased) {
                    $iterator = new SequenceIterator($threeBased);
                    $iterator->goToNext();
                    return $iterator;
                })(),
                true,
                4,
                2
            ],
            'SequenceIterator( threeBased )->goToNext()->goToNext()->goToNext()' => [
                (function () use ($threeBased) {
                    $iterator = new SequenceIterator($threeBased);
                    $iterator->goToNext();
                    $iterator->goToNext();
                    $iterator->goToNext();
                    return $iterator;
                })(),
                false,
                6,
                null
            ]
        ];
    }
}
