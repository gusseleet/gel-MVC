<?php

require __DIR__.'/config_with_app.php';
$app->theme->configure(ANAX_APP_PATH . 'config/myTheme.php');
//$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->navbar->configure(ANAX_APP_PATH . 'config/myNavbar.php');


$app->theme->setVariable('title', "HELLO!");


$app->router->add('', function () use ($app) {

    $app->theme->setTitle('Hem');
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline  = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/homepage', [
        'content' => $content,
        'byline' => $byline,
    ]);

});

$app->router->add('redovisning', function () use ($app) {
    $app->theme->setTitle("Redovisning");


    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline  = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/redovisning', [
        'content' => $content,
        'byline' => $byline,
    ]);

});

$app->router->add('sourcecode', function () use ($app) {

    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle('Källkod');

    $source = new \Mos\Source\CSource([
        'secure_dir' => '../..',
        'base_dir' => '../..',
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/sourcecode', ['content' => $source->View()]);

});

$app->router->handle();
$app->theme->render();
