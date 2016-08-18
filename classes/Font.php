<?php
/**
 * Font class
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
 * Manage fonts
 *
 * PHP version 5
 *
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */
class Font
{
    /**
     * Font class constructor
     * @param string $fontdir Font path
     */
    function __construct($fontdir)
    {
        $this->dir = realpath($fontdir);
        $this->name = basename($fontdir);
    }

    /**
     * Get repository name
     * @return string
     */
    function getRepoName()
    {
        return $this->name.'-bower';
    }

    /**
     * Get Bower pakckage name
     * @return string
     */
    function getBowerName()
    {
        return $this->name.'-googlefont';
    }
}
