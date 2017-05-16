<?php

require_once 'vendor/autoload.php';

$importer = new GoogleFontsBower\Importer();

foreach ($importer->getFonts() as $font) {
    echo $importer->log($font, 'Registering '.$font->getBowerName().'…');
    exec(
        './node_modules/.bin/bower register '.$font->getBowerName().' '.$importer->getFontRepoUrl($font)
    );
}
