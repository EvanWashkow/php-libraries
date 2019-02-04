<?php
namespace PHP\Exceptions;

/**
 * A runtime exception indicating that the value could not be found
 * 
 * Whereas an OutOfBoundsException is thrown for invalid keys, this is thrown
 * for invalid values.
 */
class NotFoundException extends \RuntimeException {}
