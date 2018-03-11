<?php

// Include local vendor libraries if being built with composer locally
if ( file_exists( __DIR__ . '/vendor/autoload.php' )) {
    require_once( __DIR__ . '/vendor/autoload.php' );
}

// $largestName = '';
$dictionary = new \PHP\Collections\Dictionary\ReadOnlyDictionary( 'integer', 'string', [ 0 => 'evan' ] );
// $index = $dictionary->Update( 0, 'evan' );
// $index = $dictionary->Add( 1, 'janna' );
// $index = $dictionary->Add( 2, 'mr. misters' );
// $dictionary->Remove(3);
// \PHP\Debug\Log::Write($dictionary);
