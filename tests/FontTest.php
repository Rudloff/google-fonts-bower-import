<?php
/**
 * FontTest class
 *
 * PHP version 5
 *
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */
require_once __DIR__.'/../classes/Font.php';
/**
 * Test Font class
 *
 * PHP version 5
 *
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */
class FontTest extends PHPUnit_Framework_TestCase
{
    private $_font;

    /**
     * Set up tests
     * @return void
     */
    protected function setUp()
    {
        $this->_font = new GoogleFontsBower\Font(
            __DIR__.'/../bower_components/google-fonts//apache/aclonica/'
        );
    }

    /**
     * Test getRepoName function
     * @return void
     */
    public function testGetRepoName()
    {
        $this->assertEquals('aclonica-bower', $this->_font->getRepoName());
    }

    /**
     * Test getBowerName function
     * @return void
     */
    public function testGetBowerName()
    {
        $this->assertEquals('aclonica-googlefont', $this->_font->getBowerName());
    }
}
