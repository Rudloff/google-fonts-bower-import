<?php
namespace GoogleFontsBower\Test;

use GoogleFontsBower\Font;

/**
 * Test Font class
 */
class FontTest extends \PHPUnit_Framework_TestCase
{
    private $font;

    /**
     * Set up tests
     * @return void
     */
    protected function setUp()
    {
        $this->font = new Font(
            __DIR__.'/../vendor/google/fonts/apache/aclonica/'
        );
    }

    /**
     * Test getRepoName function
     * @return void
     */
    public function testGetRepoName()
    {
        $this->assertEquals('aclonica-bower', $this->font->getRepoName());
    }

    /**
     * Test getBowerName function
     * @return void
     */
    public function testGetBowerName()
    {
        $this->assertEquals('aclonica-googlefont', $this->font->getBowerName());
    }
}
