<?php

namespace PHP;

// Deprecated (04-2020)
trigger_error(
    URL::class.' is deprecated.',
    E_USER_DEPRECATED
);

use PHP\Interfaces\ICloneable;

/**
 * @deprecated
 */
class URL extends ObjectClass implements ICloneable
{
    // PROPERTIES

    /**
     * The URL string.
     *
     * @var string
     */
    protected $url;

    /**
     * The URL protocol ("http").
     *
     * @var string
     */
    private $protocol;

    /**
     * The URL domain ("www.example.com").
     *
     * @var string
     */
    private $domain;

    /**
     * The URL path, following the domain ("url/path").
     *
     * @var string
     */
    private $path;

    /**
     * The URL parameters ("?var_i=foo&var_2=bar").
     *
     * @var \stdClass;
     */
    private $parameters;

    // CONSTRUCTOR

    /**
     * Create new instance of a URL.
     *
     * @param string $url The URL string
     */
    public function __construct(string $url)
    {
        $this->url = self::Sanitize($url);
    }
    // STATIC METHODS

    /**
     * Is the URL valid?
     *
     * @param string $url The URL to check
     */
    final public static function IsValid(string $url): bool
    {
        $url = filter_var($url, FILTER_VALIDATE_URL);

        return false !== $url;
    }

    /**
     * Sanitize URL, returning an empty string if not a valid URL.
     *
     * @param string $url The URL
     *
     * @return string Empty string on invalid URL
     */
    final public static function Sanitize(string $url): string
    {
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (!self::IsValid($url)) {
            $url = '';
        }

        return $url;
    }

    // METHODS

    /**
     * @see parent::clone()
     */
    public function clone(): ICloneable
    {
        return clone $this;
    }

    /**
     * Determine if this URL is the same.
     *
     * @param string|URL $value The URL to compare to
     */
    public function equals($value): bool
    {
        $equals = false;
        if (is_string($value)) {
            $equals = $this->toString() === $value;
        } elseif ($value instanceof URL) {
            $equals = $this->toString() === $value->toString();
        }

        return $equals;
    }

    /**
     * Retrieve the protocol for this URL ("http").
     *
     * @interal Final: Protocols must always follow this syntax.
     */
    final public function getProtocol(): string
    {
        if (null === $this->protocol) {
            $this->protocol = explode('://', $this->url, 2)[0];
        }

        return $this->protocol;
    }

    /**
     * Retrive the domain for this URL ("www.example.com").
     *
     * @internal final: Domains must always follow this syntax
     */
    final public function getDomain(): string
    {
        if (null === $this->domain) {
            $_url = substr($this->url, strlen($this->getProtocol()) + 3);
            $pieces = explode('?', $_url, 2);
            $pieces = explode('/', $pieces[0], 2);
            $this->domain = $pieces[0];
        }

        return $this->domain;
    }

    /**
     * Retrieve the path, following the domain, for this URL ("url/path").
     *
     * @internal final: path structure must always follow this syntax
     */
    final public function getPath(): string
    {
        if (null === $this->path) {
            $_url = substr($this->url, strlen($this->getProtocol()) + 3);
            $pieces = explode('?', $_url, 2);
            $pieces = explode('/', $pieces[0]);
            array_shift($pieces);
            $this->path = '/'.trim(implode('/', $pieces), '/');
            if (1 < strlen($this->path)) {
                $this->path = "{$this->path}/";
            }
        }

        return $this->path;
    }

    /**
     * Retrieve the parameters for this URL ("?var_1=foo&var_2=bar").
     *
     * @return \PHP\Collections\Dictionary
     */
    public function getParameters(): Collections\Dictionary
    {
        // Exit. Parameters already generated.
        if (null !== $this->parameters) {
            return $this->parameters;
        }

        // Exit. No parameters in this URL.
        $this->parameters = new \PHP\Collections\Dictionary('string', 'string');
        $index = strpos($this->url, '?');
        if (false === $index) {
            return $this->parameters;
        }

        // Build list of URL parameters, mapping key => value pairs
        $parameters = substr($this->url, $index + 1);
        $parameters = explode('&', $parameters);
        foreach ($parameters as $parameter) {
            $pieces = explode('=', $parameter, 2);
            $key = array_shift($pieces);
            if ('' === $key) {
                continue;
            }
            $value = array_shift($pieces);
            if (null === $value) {
                $value = '';
            }
            $this->parameters->set($key, $value);
        }

        return $this->parameters;
    }

    /**
     * Convert to a string.
     *
     * @internal final: there is nothing more to be done here
     */
    final public function toString(): string
    {
        return $this->url;
    }
}
