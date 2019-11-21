<?php
declare( strict_types = 1 );

namespace PHP\Enums\Exceptions;

/**
 * Exception thrown when an Enum's definition does not adhear to its type.
 * 
 * For example, but not limited to, a String Enum that attempts to define Integer constants.
 */
class MalformedEnumException extends \DomainException {}