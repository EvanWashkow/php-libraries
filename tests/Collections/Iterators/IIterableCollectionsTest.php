<?php
declare( strict_types = 1 );

namespace PHP\Tests\Collections\Iterators;

use PHP\Collections\Collection;
use PHP\Iteration\IIterable;
use PHPUnit\Framework\TestCase;

/**
 * Tests Collections' IIterable-ity
 */
class IIterableCollectionsTest extends TestCase
{


    /**
     * Ensure Collections are IIterable
     */
    public function testIsIIterable()
    {
        $collection = $this->createMock( Collection::class );
        $this->assertInstanceOf(
            IIterable::class,
            $collection,
            'Collection is not IIterable.'
        );
    }
}