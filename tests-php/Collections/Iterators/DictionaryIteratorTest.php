<?php

declare(strict_types=1);

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Dictionary;
use PHP\Collections\Iteration\IndexedIterator;
use PHP\Collections\Iterators\DeprecatedKeyValuePair;
use PHP\Collections\Iterators\DictionaryIterator;
use PHP\Types\TypeLookupSingleton;
use PHPUnit\Framework\TestCase;

/**
 * Tests the DictionaryIterator implementation.
 *
 * @internal
 * @coversNothing
 */
class DictionaryIteratorTest extends TestCase
{
    /**
     * Ensure DictionaryIterator is an instance of a IndexedIterator.
     */
    public function testIsIndexedIterator()
    {
        $this->assertInstanceOf(
            IndexedIterator::class,
            new DictionaryIterator(new Dictionary('string', 'string')),
            'DictionaryIterator is not an IndexedIterator instance.'
        );
    }

    /**
     * Test __construct() starting index is zero.
     */
    public function testConstructStartingIndex()
    {
        $this->assertEquals(
            0,
            ( new DictionaryIterator(new Dictionary('string', 'string')))->getKey(),
            'DictionaryIterator->getKey() did not return zero (0).'
        );
    }

    /**
     * Test hasCurrent().
     *
     * @dataProvider getHasCurrentTestData
     */
    public function testHasCurrent(DictionaryIterator $iterator, bool $expected)
    {
        $this->assertEquals(
            $expected,
            $iterator->hasCurrent(),
            'DictionaryIterator->hasCurrent() returned the wrong value'
        );
    }

    public function getHasCurrentTestData(): array
    {
        return [
            'Empty Dictionary' => [
                new DictionaryIterator(new Dictionary('string', 'string')),
                false,
            ],
            'Dictionary with one value' => [
                new DictionaryIterator(new Dictionary('string', 'string', ['foo' => 'bar'])),
                true,
            ],
            'Dictionary with one value => goToNext()' => [
                (function () {
                    $iterator = new DictionaryIterator(
                        new Dictionary('string', 'string', ['foo' => 'bar'])
                    );
                    $iterator->goToNext();

                    return $iterator;
                })(),
                false,
            ],
            'Dictionary with two values' => [
                new DictionaryIterator(new Dictionary('string', 'string', ['foo' => 'bar', 'biz' => 'baz'])),
                true,
            ],
            'Dictionary with two values => goToNext()' => [
                (function () {
                    $iterator = new DictionaryIterator(
                        new Dictionary('string', 'string', ['foo' => 'bar', 'biz' => 'baz'])
                    );
                    $iterator->goToNext();

                    return $iterator;
                })(),
                true,
            ],
            'Dictionary with two values => goToNext() => goToNext()' => [
                (function () {
                    $iterator = new DictionaryIterator(
                        new Dictionary('string', 'string', ['foo' => 'bar', 'biz' => 'baz'])
                    );
                    $iterator->goToNext();
                    $iterator->goToNext();

                    return $iterator;
                })(),
                false,
            ],
        ];
    }

    /**
     * Test getValue() returns the expected Key Value Pair.
     *
     * @dataProvider getValueReturnedKeyValuePairTestData
     */
    public function testGetValueReturnedKeyValuePair(DictionaryIterator $iterator, DeprecatedKeyValuePair $expected)
    {
        $this->assertEquals(
            $expected,
            $iterator->getValue(),
            'DictionaryIterator->getValue() did not return the expected Key Value Pair.'
        );
    }

    public function getValueReturnedKeyValuePairTestData(): array
    {
        $dictionary = new Dictionary('string', 'string', [
            'foo' => 'bar',
            'biz' => 'baz',
            'one' => 'two',
        ]);
        $iterator = new DictionaryIterator($dictionary);

        return [
            'Unmoved DictionaryIterator' => [
                clone $iterator,
                new DeprecatedKeyValuePair('foo', 'bar'),
            ],
            'DictionaryIterator => goToNext()' => [
                (function () use ($iterator) {
                    $iterator = clone $iterator;
                    $iterator->goToNext();

                    return $iterator;
                })(),
                new DeprecatedKeyValuePair('biz', 'baz'),
            ],
            'DictionaryIterator => goToNext() => goToNext()' => [
                (function () use ($iterator) {
                    $iterator = clone $iterator;
                    $iterator->goToNext();
                    $iterator->goToNext();

                    return $iterator;
                })(),
                new DeprecatedKeyValuePair('one', 'two'),
            ],
            'Dictionary => remove(), DictionaryIterator => goToNext()' => [
                (function () use ($dictionary) {
                    $dictionary = $dictionary->clone();
                    $dictionary->remove('biz');
                    $iterator = new DictionaryIterator($dictionary);
                    $iterator->goToNext();

                    return $iterator;
                })(),
                new DeprecatedKeyValuePair('one', 'two'),
            ],
        ];
    }

    /**
     * Test getValue() returns the correct key type.
     *
     * @todo Remove when new Collections (that don't rely on PHP arrays for key-value storage of Dictionary entries)
     * are implemented.
     *
     * @internal This is needed to ensure that PHP does not implicitly convert string keys to integers and vice-versa.
     * This was a known bug that had to be addressed.
     *
     * @dataProvider getValueKeyTypeTestData
     */
    public function testGetValueKeyType(Dictionary $dictionary)
    {
        $typeLookup = TypeLookupSingleton::getInstance();
        $iteratorKeyType = $typeLookup->getByValue($dictionary->getIterator()->getValue()->getKey());
        $this->assertTrue(
            $dictionary->getKeyType()->equals($iteratorKeyType),
            'DictionaryIterator->getValue()->getKey() returned the wrong type.'
        );
    }

    public function getValueKeyTypeTestData(): array
    {
        return [
            'integer keys' => [
                new Dictionary('int', 'string', [1 => '1']),
            ],
            'string keys' => [
                (function () {
                    $dictionary = new Dictionary('string', 'int');
                    $dictionary->set('1', 1);

                    return $dictionary;
                })(),
            ],
        ];
    }

    /**
     * Test getValue() throws OutOfBoundsException.
     */
    public function testGetValueThrowsOutOfBoundsException()
    {
        // Mock hasCurrent() as returning false
        $iterator = $this->getMockBuilder(DictionaryIterator::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasCurrent'])
            ->getMock()
        ;
        $iterator->method('hasCurrent')->willReturn(false);

        // Test
        $this->expectException(\OutOfBoundsException::class);
        $iterator->getValue();
    }
}
