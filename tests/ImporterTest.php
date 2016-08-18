<?php
/**
 * ImporterTest class
 *
 * PHP version 5
 *
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */

/**
 * Test importer class
 *
 * PHP version 5
 *
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */
class ImporterTest extends PHPUnit_Framework_TestCase
{
    private $_importer;

    /**
     * Set up tests
     * @return void
     */
    protected function setUp()
    {
        $this->_importer = new GoogleFontsBower\Importer();
        $this->_font = new GoogleFontsBower\Font(
            __DIR__.'/../bower_components/google-fonts//apache/aclonica/'
        );
    }

    /**
     * Test getFonts function
     * @return void
     */
    public function testGetFonts()
    {
        $fonts = $this->_importer->getFonts();
        $this->assertEquals($fonts[0], $this->_font);
    }

    /**
     * Test log function
     * @return void
     */
    public function testLog()
    {
        $this->assertEquals(
            '[aclonica] Test'.PHP_EOL,
            $this->_importer->log($this->_font, 'Test')
        );
    }

    /**
     * Test getFontRepoUrl function
     * @return void
     */
    public function testGetFontRepoUrl()
    {
        $this->assertEquals(
            'git@github.com:google-fonts-bower/aclonica-bower.git',
            $this->_importer->getFontRepoUrl($this->_font)
        );
    }
}
