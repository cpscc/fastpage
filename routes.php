<?php
$app = new \Slim\Slim();


/**
 * Template Dashboard
 */
$app->get('/templates', function () use ($app) {
    render('templates', template_list());
});

$app->get('/templates/create', function ($name) use ($app) {
    render('template_x', ['create'=>true]);
});

$app->get('/templates/:name', function ($name) use ($app) {
    $template = template_fetch($name);
    render('template_x', $template);
});

$app->post('/templates(/:name)/', function ($name) use ($app) {
    if (!$name) $name = $_REQUEST['name'];

    if (template_update($name, $_REQUEST, $_SESSION['flash']['alert'])) {
        $_SESSION['flash']['success'] = ($_REQUEST['create']) ? 'Template successfully created!' : 'Template successfully updated!';
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
 * Page Dashboard
 */
$app->get('/pages', function () use ($app) {
    render('pages', page_list());
});

$app->get('/pages/create', function ($name) use ($app) {
    render('page_x', ['create'=>true] + template_list());
});

$app->get('/pages/:name', function ($name) use ($app) {
    $page = page_fetch($name);
    $model = ['page'=>render_keys($page)] + template_list() + compact('name');

    $model['editing_template'] =
        render(name_encode($page->theme)."_edit", $model, false, true);

    render('page_x', $model);
});

$app->post('/pages(/:name)', function ($name) use ($app) {
    // make sure _add_keys and theme get stored
    if (page_update($name, $_REQUEST, $_SESSION['flash']['alert'])) {
        $_SESSION['flash']['success'] = 'Page successfully updated!';
        $app->response->redirect('/pages/' . urlencode($_REQUEST['name']));
    } else {
        $_SESSION['flash'] = $_SESSION['flash'] + array_select_keys($_REQUEST, ['name','css','view','data','edit']);
        $app->response->redirect('/pages/' . urlencode($name));
    }
});

$app->get('/pages/:name/delete', function ($name) use ($app) {
    render('confirm', ['message'=>"Are you sure you want to delete '$name'?"]);
});

$app->post('/pages/:name/delete', function ($name) use ($app) {
    if (page_delete($name, $error)) {
        $_SESSION['flash']['success'] = "Page '$name' successfully deleted!";
        $app->response->redirect('/pages');
    } else {
        $_SESSION['flash']['alert'] = "Something went wrong deleting '$name'";
        $app->response->redirect('/pages/' . urlencode($name));
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
