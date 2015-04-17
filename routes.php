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

$app->post('/templates/:name', function ($name) use ($app) {
    if (template_update($name, $_REQUEST, $_SESSION['flash']['alert'])) {
        $_SESSION['flash']['success'] = 'Template successfully updated!';
        $app->response->redirect('/templates/' . urlencode($_REQUEST['name']));
    } else {
        $_SESSION['flash'] = $_SESSION['flash'] + array_select_keys($_REQUEST, ['name','css','view','data','edit']);
        $app->response->redirect('/templates/' . urlencode($name));
    }
});

$app->get('/templates/:name/delete', function ($name) use ($app) {
    render('confirm', ['message'=>"Are you sure you want to delete '$name'?"]);
});

$app->post('/templates/:name/delete', function ($name) use ($app) {
    if (template_delete($name, $error)) {
        $_SESSION['flash']['success'] = "Template '$name' successfully deleted!";
        $app->response->redirect('/templates');
    } else {
        $_SESSION['flash']['alert'] = "Something went wrong deleting '$name'";
        $app->response->redirect('/templates/' . urlencode($name));
    }
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
