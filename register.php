<?php
/**
 * Register Bower packages
 * 
 * PHP version 5
 * 
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */
require_once 'vendor/autoload.php';
require_once 'classes/Importer.php';

$importer = new GoogleFontsBower\Importer;

foreach ($importer->getFonts() as $font) {
    print $importer->log($font, 'Registering '.$font->getBowerName().'…');
    exec(
        'bower register '.$font->getBowerName().' '.$importer->getFontRepoUrl($font)
    );
}
