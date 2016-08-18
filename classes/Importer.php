<?php
/**
 * Importer class
 *
 * PHP version 5
 *
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */
namespace GoogleFontsBower;

/**
 * Manager fonts import
 *
 * PHP version 5
 *
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */
class Importer
{
    public $fontsDir;
    public $fontsRepoUrl = 'git@github.com:google/fonts.git';
    public $baseRepoOrg = 'google-fonts-bower';
    public $baseRepoUrl = 'git@github.com:google-fonts-bower/';
    public $gitAuthor = 'Pierre Rudloff <contact@rudloff.pro>';

    /**
     * Importer class constructor
     */
    public function __construct()
    {
        $this->fontsDir = __DIR__.'/../bower_components/google-fonts/';
    }

    /**
     * Get all fonts
     * @return Font[]
     */
    public function getFonts()
    {
        $fonts = array();
        foreach (glob($this->fontsDir.'/*/*/') as $fontdir) {
            $fonts[] = new Font($fontdir);
        }
        return $fonts;
    }

    /**
     * Generate log message
     * @param Font   $font Font mentioned in this message
     * @param string $msg  Message
     * @return string Log message
     */
    public function log($font, $msg)
    {
        return '['.$font->name.'] '.$msg.PHP_EOL;
    }

    /**
     * Get repository URL for this font
     * @param  Font $font Font
     * @return string URL
     */
    public function getFontRepoUrl($font)
    {
        return $this->baseRepoUrl.$font->getRepoName($font).'.git';
    }
}
