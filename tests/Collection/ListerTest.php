<?php

namespace EvanWashkow\PhpLibraries\Tests\Collection;
use EvanWashkow\PhpLibraries\Collection\ArrayList;
use EvanWashkow\PhpLibraries\CollectionInterface\Lister;
use EvanWashkow\PhpLibraries\Tests\TestCase;
use EvanWashkow\PhpLibraries\TypeInterface\Type;

final class ListerTest extends TestCase
{
    /**
     * @dataProvider getAddInvalidValueTypeTests
     */
    public function testAddInvalidValueType(Lister $list, mixed $value) {
        $this->expectException(\TypeError::class);
        $list->add($value);
    }

    public function getAddInvalidValueTypeTests(): array {
        return array_merge(
            InvalidValueTypes::create("", ArrayList::class, static function(Type $valueType) {
                return new ArrayList($valueType);
            }),
        );
    }
}
