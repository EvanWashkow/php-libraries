<?php
namespace PHP\Tests;

use PHP\URL;

require_once( __DIR__ . '/TestCase.php' );

/**
 * Tests the URL class functions
 */
class URLTest extends TestCase
{
    
    /***************************************************************************
    *                                 IsValid()
    ***************************************************************************/
    
    
    /**
     * Ensure URL::IsValid() returns true for valid URLs
     */
    public function testIsValidReturnsTrue()
    {
        foreach ( self::getURLs() as $url => $urlInfo ) {
            $this->assertTrue(
                URL::IsValid( $url ),
                "Expected URL::IsValid() to return true for valid URLs"
            );
        }
    }
    
    
    /**
     * Ensure URL::IsValid() returns false for invalid URLs
     */
    public function testIsValidReturnsFalse()
    {
        $this->assertFalse(
            URL::IsValid( 'foobar' ),
            "Expected URL::IsValid() to return false for invalid URLs"
        );
    }
    
    
    
    
    /***************************************************************************
    *                                Sanitize()
    ***************************************************************************/
    
    
    /**
     * Ensure URL::Sanitize() returns trimmed string
     */
    public function testSanitizeReturnsTrimmedString()
    {
        foreach ( self::getURLs() as $url => $urlInfo ) {
            $this->assertEquals(
                $url,
                URL::Sanitize( "  {$url}  " ),
                "Expected URL::Sanitize() to return a trimmed string"
            );
            break;
        }
    }
    
    
    
    /**
     * Ensure URL::Sanitize() returns empty string on invalid URL
     */
    public function testSanitizeReturnsEmptyStringOnInvalid()
    {
        $this->assertEquals(
            '',
            URL::Sanitize( 'foobar' ),
            "Expected URL::Sanitize() to return a empty string on invalid URL"
        );
    }
    
    
    
    
    /***************************************************************************
    *                               ACCESSORS
    ***************************************************************************/
    
    
    /**
     * Ensure URL->getProtocol() returns the protocol
     */
    public function testGetProtocolReturnsProtocol()
    {
        foreach ( self::getURLs() as $url => $urlInfo ) {
            $url = new URL( $url );
            $this->assertEquals(
                $urlInfo[ 'protocol' ],
                $url->getProtocol(),
                "Expected URL->getProtocol() to return the protocol"
            );
        }
    }
    
    
    /**
     * Ensure URL->getDomain() returns the domain
     */
    public function testGetDomainReturnsDomain()
    {
        foreach ( self::getURLs() as $url => $urlInfo ) {
            $url = new URL( $url );
            $this->assertEquals(
                $urlInfo[ 'domain' ],
                $url->getDomain(),
                "Expected URL->getDomain() to return the domain"
            );
        }
    }
    
    
    /**
     * Ensure URL->getPath() returns the path
     */
    public function testGetPathReturnsPath()
    {
        foreach ( self::getURLs() as $url => $urlInfo ) {
            $url = new URL( $url );
            $this->assertEquals(
                $urlInfo[ 'path' ],
                $url->getPath(),
                "Expected URL->getPath() to return the path"
            );
        }
    }
    
    
    /**
     * Ensure URL->getParameters() returns the parameters
     */
    public function testGetParametersReturnsParameters()
    {
        foreach ( self::getURLs() as $url => $urlInfo ) {
            $url           = new URL( $url );
            $parameters    = $url->getParameters();
            $hasParameters = true;
            foreach ( $urlInfo[ 'parameters' ] as $key => $value) {
                $hasParameters = (
                    $parameters->hasKey( $key ) &&
                    ( $parameters->get( $key ) === $value )
                );
                if ( !$hasParameters ) {
                    break;
                }
            }
            $this->assertTrue(
                $hasParameters,
                "Expected URL->getParameters() to return the parameters"
            );
        }
    }
    
    
    /**
     * Ensure URL->toString() returns sanitized URL string
     */
    public function testToStringReturnsSanitizedUrlString()
    {
        foreach ( self::getURLs() as $url => $urlInfo ) {
            $urlInstance = new URL( '  ' . $url . '  ' );
            $this->assertTrue(
                $urlInstance->toString() === $url,
                "Expected URL->toString() to return the sanitized URL string"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                                   DATA
    ***************************************************************************/
    
    /**
     * Retrieves an array of sample URLs
     *
     * @return array
     */
    private static function getURLs(): array
    {
        // URL parts
        $protocols = [ 'https', 'http' ];
        $domains   = [ 'google.com', 'www.google.com' ];
        $paths     = [
            ''               => '/',
            '/'              => '/',
            '/path/to/file'  => '/path/to/file/',
            '/path/to/file/' => '/path/to/file/'
        ];
        $parameters = [
            ''                 => [],
            '?'                => [],
            '?foo'             => [ 'foo' => '' ],
            '?foo=bar'         => [ 'foo' => 'bar' ],
            '?foo=bar&biz'     => [ 'foo' => 'bar', 'biz' => '' ],
            '?foo=bar&biz=baz' => [ 'foo' => 'bar', 'biz' => 'baz' ],
            
        ];
        
        // Build test URLs
        $urls = [];
        foreach ( $protocols as $protocol ) {
            foreach ( $domains as $domain ) {
                foreach ( $paths as $actualPath => $expectedPath ) {
                    foreach ( $parameters as $actualParam => $expectedParam ) {
                        $urls[
                            "{$protocol}://{$domain}{$actualPath}{$actualParam}"
                        ] = [
                            'protocol'   => $protocol,
                            'domain'     => $domain,
                            'path'       => $expectedPath,
                            'parameters' => $expectedParam,
                        ];
                    }
                }
            }
        }
        return $urls;
    }
}
