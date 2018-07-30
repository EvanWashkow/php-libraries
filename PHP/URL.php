<?php
namespace PHP;

/**
 * Defines a URL string
 */
class URL extends PHPObject implements IPHPObject
{
    
    /***************************************************************************
    *                                STATIC METHODS
    ***************************************************************************/
    
    /**
     * Is the URL valid?
     *
     * @param string $url The URL to check
     * @return bool
     */
    final public static function IsValid( string $url ): bool
    {
        $url = filter_var( $url, FILTER_VALIDATE_URL );
        return ( false !== $url );
    }


    /**
     * Sanitize URL, returning an empty string if not a valid URL
     *
     * @param string $url The URL
     * @return string Empty string on invalid URL
     */
    final public static function Sanitize( string $url ): string
    {
        $url = filter_var( $url, FILTER_SANITIZE_URL );
        if ( !self::IsValid( $url )) {
            $url = '';
        }
        return $url;
    }
    
    
    /***************************************************************************
    *                                  PROPERTIES
    ***************************************************************************/
    
    /**
     * The URL string
     *
     * @var string
     */
    protected $url;
    
    /**
     * The URL protocol ("http")
     *
     * @var string
     */
    private $protocol = null;
    
    /**
     * The URL domain ("www.example.com")
     *
     * @var string
     */
    private $domain = null;
    
    /**
     * The URL path, following the domain ("url/path")
     *
     * @var string
     */
    private $path = null;
    
    /**
     * The URL parameters ("?var_i=foo&var_2=bar")
     *
     * @var \stdClass;
     */
    private $parameters = null;
    
    
    /***************************************************************************
    *                                 CONSTRUCTOR
    ***************************************************************************/
    
    /**
     * Create new instance of a URL
     *
     * @param string $url The URL string
     */
    public function __construct( string $url )
    {
        $this->url = self::Sanitize( $url );
    }
    
    
    /***************************************************************************
    *                                   METHODS
    ***************************************************************************/
    
    /**
     * Retrieve the protocol for this URL ("http")
     *
     * @return string
     */
    final public function getProtocol(): string
    {
        if ( null === $this->protocol ) {
            $this->protocol = explode( '://', $this->url, 2 )[ 0 ];
        }
        return $this->protocol;
    }
    
    
    /**
     * Retrive the domain for this URL ("www.example.com")
     *
     * @return string
     */
    final public function getDomain(): string
    {
        if ( null === $this->domain ) {
            $_url   = substr( $this->url, strlen( $this->getProtocol() ) + 3 );
            $pieces = explode( '?',   $_url,        2 );
            $pieces = explode( '/',   $pieces[ 0 ], 2 );
            $this->domain = $pieces[ 0 ];
        }
        return $this->domain;
    }
    
    
    /**
     * Retrieve the path, following the domain, for this URL ("url/path")
     *
     * @return string
     */
    final public function getPath(): string
    {
        if ( null === $this->path ) {
            $_url   = substr( $this->url, strlen( $this->getProtocol() ) + 3);
            $pieces = explode( '?', $_url, 2 );
            $pieces = explode( '/', $pieces[ 0 ] );
            array_shift( $pieces );
            $this->path = '/' . trim( implode( '/', $pieces ), '/' );
            if ( 1 < strlen( $this->path )) {
                $this->path = "{$this->path}/";
            }
        }
        return $this->path;
    }
    
    
    /**
     * Retrieve the parameters for this URL ("?var_1=foo&var_2=bar")
     *
     * @return \PHP\Collections\Dictionary
     */
    final public function getParameters(): \PHP\Collections\Dictionary
    {
        if ( null === $this->parameters ) {
            $this->parameters = new \PHP\Collections\Dictionary( 'string', 'string' );
            $index = strpos( $this->url, '?' );
            if ( false === $index ) {
                $_parameters = substr( $this->url, $index + 1 );
                $_parameters = explode( '&', $_parameters );
                foreach ( $_parameters as $_parameter ) {
                    $pieces = explode( '=', $_parameter, 2 );
                    $key    = array_shift( $pieces );
                    if ( '' === $key ) {
                        continue;
                    }
                    $value  = array_shift( $pieces );
                    if ( null === $value ) {
                        $value = '';
                    }
                    $this->parameters->set( $key, $value );
                }
            }
        }
        return $this->parameters;
    }
    
    
    /**
     * Convert to a string
     *
     * @return string
     */
    final public function toString(): string
    {
        return $this->url;
    }
}
