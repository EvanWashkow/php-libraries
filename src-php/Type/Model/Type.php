<?php
declare(strict_types=1);

namespace PHP\Type\Model;

use PHP\Collections\ByteArray;

/**
 * Defines a PHP Type
 */
abstract class Type extends \PHP\ObjectClass
{
    /** @var string The type name */
    private $name;


    /**
     * Creates a new Type instance
     *
     * @param string $name The type name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * Retrieves this type name
     */
    final public function getName(): string
    {
        return $this->name;
    }


    final public function hash(): ByteArray
    {
        return new ByteArray($this->name);
    }
}
