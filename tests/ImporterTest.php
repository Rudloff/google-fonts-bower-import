<?php
namespace GoogleFontsBower\Test;

use GoogleFontsBower\Importer;
use GoogleFontsBower\Font;

/**
 * Test importer class
 */
class ImporterTest extends \PHPUnit_Framework_TestCase
{
    private $importer;
    private $font;

    /**
     * Set up tests
     * @return void
     */
    protected function setUp()
    {
        $this->importer = new Importer();
        $this->font = new Font(
            __DIR__.'/../vendor/google/fonts/apache/aclonica/'
        );
    }

    /**
     * Test getFonts function
     * @return void
     */
    public function testGetFonts()
    {
        $fonts = $this->importer->getFonts();
        $this->assertEquals($fonts[0], $this->font);
    }

    /**
     * Test log function
     * @return void
     */
    public function testLog()
    {
        $this->assertEquals(
            '[aclonica] Test'.PHP_EOL,
            $this->importer->log($this->font, 'Test')
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
            $this->importer->getFontRepoUrl($this->font)
        );
    }
}
