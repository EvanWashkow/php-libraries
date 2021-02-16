<?php
declare(strict_types=1);

namespace PHP\Type\Model;

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
}
