<?php

require_once __DIR__.'/vendor/autoload.php';

$github = new \Github\Client();

$importer = new GoogleFontsBower\Importer();

foreach ($importer->getFonts() as $font) {
    $dir_handle = opendir($font->dir);
    $repo = 'repos/'.$font->name.'/';
    $github->authenticate(trim(file_get_contents(__DIR__.'/token.txt')), \Github\Client::AUTH_HTTP_TOKEN);

    try {
        echo $importer->log($font, 'Creating repository on GitHub…');
        $api = $github->api('repo');
        if ($api instanceof Github\Api\Repo) {
            $api->create($font->getRepoName(), null, null, true, $importer->baseRepoOrg);
        }
    } catch (Exception $e) {
        if ($e->getCode() == 401) {
            die('Wrong Github credentials!'.PHP_EOL);
        } elseif ($e->getCode() == 422) {
            echo $importer->log($font, 'Reusing existing repository');
        } else {
            die($e->getMessage().PHP_EOL);
        }
    }

    echo $importer->log($font, 'Updating local repository…');
    $repository = Gitonomy\Git\Admin::init($repo, false);
    try {
        echo $repository->run(
            'remote',
            ['add', 'origin', $importer->getFontRepoUrl($font)]
        );
    } catch (Exception $e) {
        echo $repository->run(
            'remote',
            ['set-url', 'origin', $importer->getFontRepoUrl($font)]
        );
    }

    try {
        echo $importer->log(
            $font,
            $repository->run('pull', ['origin', 'master'])
        );
    } catch (Exception $e) {
        echo $importer->log($font, 'Remote repository is empty');
    }

    echo $importer->log($font, 'Copying files in '.$repo.'…');
    if (!is_dir($repo)) {
        mkdir($repo);
    }
    array_map('unlink', glob($repo.'/*'));
    while ($file = readdir($dir_handle)) {
        if ($file != '.' && $file != '..') {
            copy($font->dir.'/'.$file, $repo.$file);
        }
    }
    closedir($dir_handle);
    echo $importer->log($font, 'Generating bower.json…');
    file_put_contents($repo.'/bower.json', $font->getBowerJson());
    echo $repository->run('add', ['.']);
    try {
        echo $importer->log($font, 'Committing new changes…');
        $repository->run(
            'commit',
            [
                '-m Import from '.$importer->fontsRepoUrl,
                '--author='.$importer->gitAuthor,
            ]
        );
    } catch (Exception $e) {
        echo $importer->log($font, 'Nothing to commit');
    }

    echo $importer->log(
        $font,
        $repository->run('push', ['--set-upstream', 'origin', 'master'])
    );
}
