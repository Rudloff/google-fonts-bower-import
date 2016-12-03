<?php

namespace GoogleFontsBower\Test;

use GoogleFontsBower\Font;

/**
 * Test Font class.
 */
class FontTest extends \PHPUnit_Framework_TestCase
{
    private $font;

    /**
     * Set up tests.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->font = new Font(
            __DIR__.'/../vendor/google/fonts/apache/aclonica/'
        );
    }

    /**
     * Test getRepoName function.
     *
     * @return void
     */
    public function testGetRepoName()
    {
        $this->assertEquals('aclonica-bower', $this->font->getRepoName());
    }

    /**
     * Test getBowerName function.
     *
     * @return void
     */
    public function testGetBowerName()
    {
        $this->assertEquals('aclonica-googlefont', $this->font->getBowerName());
    }

    /**
     * Test getBowerJson function.
     *
     * @return void
     */
    public function testGetBowerJson()
    {
        $this->assertEquals('{
    "name": "aclonica-googlefont",
    "license": "APACHE2",
    "authors": [
        "Astigmatic"
    ],
    "homepage": "https://fonts.google.com/",
    "repository": {
        "type": "git",
        "url": "https://github.com/google-fonts-bower/aclonica-bower.git"
    },
    "description": "Aclonica font",
    "keywords": [
        "font",
        "SANS_SERIF"
    ]
}
', $this->font->getBowerJson());
    }
}
