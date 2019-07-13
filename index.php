<?php

// Include local vendor libraries if being built with composer locally
if ( file_exists( __DIR__ . '/vendor/autoload.php' )) {
    require_once( __DIR__ . '/vendor/autoload.php' );
}

// Change debug directory if specified
if ( getenv( 'error_log' ) ) {
    ini_set( 'error_log', getenv( 'error_log' ) );
}