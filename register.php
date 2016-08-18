<?php
require_once 'vendor/autoload.php';
require_once 'classes/Importer.php';

$importer = new GoogleFontsBower\Importer;

foreach ($importer->getFonts() as $font) {
    print $importer->log($font, 'Registering '.$font->getBowerName().'…');
    exec(
        'bower register '.$font->getBowerName().' '.$importer->getFontRepoUrl($font)
    );
}
