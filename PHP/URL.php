<?php
namespace PHP;

/**
 * Defines a URL string
 */
class URL
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
    final public static function IsValid( string $url )
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
    final public static function Sanitize( string $url )
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
    
    
    /**
     * Extract the URL into its various pieces
     *
     * 
     * @param string $url         The URL to extract
     * @param string &$protocol   The resulting protocol ('http'/'https')
     * @param string &$domain     The resulting domain   ('google.com')
     * @param string &$path       The resulting path     ('/url/path/structure/')
     * @param array  &$parameters The resulting GET parameters as a mapped array
     */
    final public static function Extract( string $url,
                                                 &$protocol   = '',
                                                 &$domain     = '',
                                                 &$path       = '',
                                                 &$parameters = [] )
    {
        
        // Exit. Bad URL.
        $url = self::Sanitize( $url );
        if ( '' == $url ) {
            return;
        }
        
        // Set variables
        $protocol   = '';
        $domain     = '';
        $path       = '';
        $parameters = [];
        
        // Extract URL pieces
        $pieces   = explode( '/', $url );
        $protocol = array_shift( $pieces );
        $protocol = substr( $protocol, 0, strlen( $protocol ) - 1 );
        $domain   = array_shift( $pieces );
        $domain   = array_shift( $pieces );
        $_url     = implode( '/', $pieces );
        $pieces   = explode( '?', $_url );
        $path     = '/' . $pieces[ 0 ];
        
        // Build URL parameters mapped array
        if ( array_key_exists( 1, $pieces )) {
            $pieces = explode( '&', $pieces[ 1 ] );
            foreach ( $pieces as $piece ) {
                $map   = explode( '=', $piece );
                $key   = $map[ 0 ];
                $value = NULL;
                if ( array_key_exists( 1, $map )) {
                    $value = $map[ 1 ];
                }
                $parameters[ $key ] = $value;
            }
        }
    }
}
