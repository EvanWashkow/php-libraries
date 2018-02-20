<?php
// INCLUDE THIS FIRST: in charge of loading the extension with its dependencies

// Include local vendor libraries if being built with composer locally
if ( file_exists( __DIR__ . '/vendor/autoload.php' )) {
    require_once( __DIR__ . '/vendor/autoload.php' );
}

// Load main file
require_once( __DIR__ . '/PHP.php' );
