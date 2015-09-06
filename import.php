<?php
/**
 * Import Google Fonts and push them to GitHub
 * 
 * PHP version 5
 * 
 * @category GoogleFontsBower
 * @package  GoogleFontsBower
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/google-fonts-bower
 * */
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/classes/Importer.php';
use Gitonomy\Git\Repository;

$github = new \Github\Client();

$importer = new GoogleFontsBower\Importer;

$githubUser = readline('GitHub username: ');
print 'GitHub password: ';
$githubPass = preg_replace('/\r?\n$/', '', `stty -echo; head -n1 ; stty echo`);
print PHP_EOL;

foreach ($importer->getFonts() as $font) {
    $dir_handle=opendir($font->dir);
    $repo = 'repos/'.$font->name.'/';
    print $importer->log($font, 'Copying files in '.$repo.'…');
    if (!is_dir($repo)) {
        mkdir($repo);
    }
    while ($file=readdir($dir_handle)) {
        if ($file!="." && $file!="..") {
            copy($font->dir.'/'.$file, $repo.$file);
        }
    }
    closedir($dir_handle);
    $repository = Gitonomy\Git\Admin::init($repo, false);
    print $repository->run('add', array('.'));
    try {
        print $importer->log($font, 'Committing new changes…');
        $repository->run(
            'commit',
            array(
                '-m Import from '.$importer->fontsRepoUrl,
                '--author='.$importer->gitAuthor
            )
        );
    } catch (Exception $e) {
        print $importer->log($font, 'Nothing to commit');
    }
    try {
        print $repository->run(
            'remote', array('add', 'origin', $importer->getFontRepoUrl($font))
        );
    } catch (Exception $e) {
        print $repository->run(
            'remote', array('set-url', 'origin', $importer->getFontRepoUrl($font))
        );
    }

    $github->authenticate($githubUser, $githubPass);

    try {
        print $importer->log($font, 'Creating repository on GitHub…'); 
        $github->api('repo')
            ->create($font->getRepoName(), null, null, true, $importer->baseRepoOrg);
    } catch (Exception $e) {
        if ($e->getCode() == 401) {
            die('Wrong Github credentials!'.PHP_EOL);
        } else if ($e->getCode() == 422) {
            print $importer->log($font, 'Reusing existing repository');
        }
    }

    print $importer->log(
        $font, $repository->run('push', array('--set-upstream', 'origin', 'master'))
    );
}
