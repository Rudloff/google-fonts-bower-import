<?php
namespace GoogleFontsBower;

/**
 * Manage fonts
 */
class Font
{
    /**
     * Font class constructor
     * @param string $fontdir Font path
     */
    public function __construct($fontdir)
    {
        $this->dir = realpath($fontdir);
        $this->name = basename($fontdir);
    }

    /**
     * Get repository name
     * @return string
     */
    public function getRepoName()
    {
        return $this->name.'-bower';
    }

    /**
     * Get Bower pakckage name
     * @return string
     */
    public function getBowerName()
    {
        return $this->name.'-googlefont';
    }
}
