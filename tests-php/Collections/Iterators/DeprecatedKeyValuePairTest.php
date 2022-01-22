<?php

declare(strict_types=1);

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Iterators\DeprecatedKeyValuePair;
use PHP\Collections\KeyValuePair;
use PHPUnit\Framework\TestCase;

/**
 * Tests DeprecatedKeyValuePair
 */
class DeprecatedKeyValuePairTest extends TestCase
{
    /**
     * Ensure it is a KeyValuePair
     */
    public function testIsKeyValuePair()
    {
        $this->assertInstanceOf(
            KeyValuePair::class,
            new DeprecatedKeyValuePair('one', 'two'),
            'DeprecatedKeyValuePair is not a KeyValuePair.'
        );
    }
}
