<?php
$app = new \Slim\Slim();

/**
 * List of templates
 */
$app->get('/templates', function () use ($app) {
    render('templates', template_list());
});

/**
 * Display Pages
 */
$app->get('/', function () use ($app) {
    render('index', page_list());
});

$app->get('/:name', function ($name) use ($app) {
    $page = page_fetch($name);
    $theme = bin2hex($page->theme);
    render(page_template($page), compact('page','theme'));
});


$app->run();
exit;
