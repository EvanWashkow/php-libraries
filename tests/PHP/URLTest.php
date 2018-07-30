<?php

require_once( __DIR__ . '/TestCase.php' );

/**
 * Tests the URL class functions
 */
class URLTest extends TestCase
{
    
    /***************************************************************************
    *                                   DATA
    ***************************************************************************/
    
    /**
     * Retrieves an array of sample URLs
     *
     * @return array
     */
    public static function getURLs(): array
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
                            'protocol'  => $protocol,
                            'domain'    => $domain,
                            'path'      => $expectedPath,
                            'parameter' => $expectedParam,
                        ];
                    }
                }
            }
        }
        return $urls;
    }
}
