<?php
$app = new \Slim\Slim();

/**
 * List of pages
 */
$app->get('/', function () use ($app) {
    render('index', page_list());
});

/**
 * List of templates
 */
$app->get('/templates', function () use ($app) {
    render('index');
});


/**
 * Admininistration
 */
$app->get('/administrative_management', function () use ($app) {
    if (!admin())
        $app->response->redirect('/create_admin_session');

    $model = ['links'=>load_repo('links')];
    $model = is_array($_SESSION['flash']) ? array_merge($model, $_SESSION['flash']) : $model;
    render('administrative_management', $model);
});

$app->post('/administrative_management', function () use ($app) {
    if (!admin())
        $app->response->redirect('/create_admin_session');

    if (update_links($_POST['links'], $error)) {
        $_SESSION['flash']['success'] = "Nice update! Go have a cookie";
        return $app->response->redirect('/administrative_management');
    }
    $_SESSION['flash']['error'] = $error;
    $_SESSION['flash']['links'] = $_POST['links'];
    return $app->response->redirect('/administrative_management');
});

$app->run();
exit;
