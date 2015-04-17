<?php
$app = new \Slim\Slim();

/**
 * Template Dashboard
 */
$app->get('/templates', function () use ($app) {
    render('templates', template_list());
});

$app->get('/templates/:name', function ($name) use ($app) {
    $template = template_fetch($name);
    render('template_x', $template);
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
