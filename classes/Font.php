<?php
namespace GoogleFontsBower;

use Symfony\Component\Yaml\Yaml;

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

    private function getMetadata()
    {
        //I know it is protobuf, but YAML is way easier to parse
        $yaml = file_get_contents($this->dir.'/METADATA.pb');
        $yaml = preg_replace('/fonts {.*}/s', '', $yaml);
        return Yaml::parse($yaml);
    }

    public function getBowerJson()
    {
        $metadata = $this->getMetadata();
        $bower = array(
            'name'=>$this->getBowerName(),
            'license'=>$metadata['license'],
            'authors'=>array($metadata['designer']),
            'homepage'=>'https://fonts.google.com/',
            'repository'=>array(
                'type'=>'git',
                'url'=>'https://github.com/google-fonts-bower/'.$this->getRepoName().'.git'
            ),
            'description'=>$metadata['name'].' font',
            'keywords'=>array('font', $metadata['category'])
        );
        return json_encode($bower, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES).PHP_EOL;
    }
}
