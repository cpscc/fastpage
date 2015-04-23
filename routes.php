<?php
$app = new \Slim\Slim();


/**
 * Login
 */
$app->get('/close_session', function () use ($app) {
    $_SESSION = [];
    $app->response->redirect('/create_session');
});

$app->get('/create_session', function () use ($app) {
    render('create_session', $_SESSION['flash']);
});

$app->post('/create_session', function () use ($app) {
    if ($user = user_verify($_POST, $error)) {
        create_session($user['role']);
        return $app->response->redirect('/pages');
    }
    $_SESSION['flash'] = array_select_keys($_POST, ['login','password']);
    $_SESSION['flash']['alert'] = $error;
    return $app->response->redirect('/create_session');
});

$app->get('/not_allowed', function () use ($app) {
    render('not_allowed');
});


/**
 * Template Dashboard
 */
$app->get('/templates', function () use ($app) {
    authenticate_admin($app);
    render('templates', template_list());
});

$app->get('/templates/create', function ($name) use ($app) {
    authenticate_admin($app);
    render('template_x', ['create'=>true]);
});

$app->get('/templates/:name', function ($name) use ($app) {
    authenticate_admin($app);

    $template = template_fetch($name);
    render('template_x', $template);
});

$app->post('/templates(/:name)/', function ($name) use ($app) {
    authenticate_admin($app);

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
    authenticate_admin($app);

    render('confirm', ['message'=>"Are you sure you want to delete '$name'?"]);
});

$app->post('/templates/:name/delete', function ($name) use ($app) {
    authenticate_admin($app);

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
$app->get('/pages/', function () use ($app) {
    authenticate($app);

    render('pages', page_list());
});

$app->get('/pages/create', function ($name) use ($app) {
    authenticate($app);

    render('page_x', ['create'=>true] + template_list());
});

$app->get('/pages/:name', function ($name) use ($app) {
    authenticate($app);

    $page = page_fetch($name);
    $model = ['page'=>render_keys($page)] + compact('name');

    $model['editing_template'] =
        render(name_encode($page->theme)."_edit", $model, false, true);

    render('page_x', $model);
});

$app->post('/pages(/:name)/', function ($name) use ($app) {
    authenticate($app);

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
    authenticate($app);

    render('confirm', ['message'=>"Are you sure you want to delete '$name'?"]);
});

$app->post('/pages/:name/delete', function ($name) use ($app) {
    authenticate($app);

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
    $theme = name_encode($page->theme);
    render(page_template($page), compact('page','theme'));
});


$app->run();
exit;
