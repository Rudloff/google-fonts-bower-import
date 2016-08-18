<?php
use Gitonomy\Git\Repository;

require_once __DIR__.'/vendor/autoload.php';

$github = new \Github\Client();

$importer = new GoogleFontsBower\Importer;

foreach ($importer->getFonts() as $font) {
    $dir_handle=opendir($font->dir);
    $repo = 'repos/'.$font->name.'/';
    $github->authenticate(trim(file_get_contents(__DIR__.'/token.txt')), \Github\Client::AUTH_HTTP_TOKEN);

    try {
        print $importer->log($font, 'Creating repository on GitHub…');
        $github->api('repo')
            ->create($font->getRepoName(), null, null, true, $importer->baseRepoOrg);
    } catch (Exception $e) {
        if ($e->getCode() == 401) {
            die('Wrong Github credentials!'.PHP_EOL);
        } elseif ($e->getCode() == 422) {
            print $importer->log($font, 'Reusing existing repository');
        } else {
            die($e->getMessage().PHP_EOL);
        }
    }

    print $importer->log($font, 'Updating local repository…');
    $repository = Gitonomy\Git\Admin::init($repo, false);
    try {
        print $repository->run(
            'remote',
            array('add', 'origin', $importer->getFontRepoUrl($font))
        );
    } catch (Exception $e) {
        print $repository->run(
            'remote',
            array('set-url', 'origin', $importer->getFontRepoUrl($font))
        );
    }

    try {
        print $importer->log(
            $font,
            $repository->run('pull', array('origin', 'master'))
        );
    } catch (Exception $e) {
        print $importer->log($font, 'Remote repository is empty');
    }

    print $importer->log($font, 'Copying files in '.$repo.'…');
    if (!is_dir($repo)) {
        mkdir($repo);
    }
    array_map('unlink', glob($repo.'/*'));
    while ($file=readdir($dir_handle)) {
        if ($file!="." && $file!="..") {
            copy($font->dir.'/'.$file, $repo.$file);
        }
    }
    closedir($dir_handle);
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

    print $importer->log(
        $font,
        $repository->run('push', array('--set-upstream', 'origin', 'master'))
    );
}
