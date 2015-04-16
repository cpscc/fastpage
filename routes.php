<?php
$app = new \Slim\Slim();

/**
 * Training Materials
 */
$app->get('/', function () use ($app) {
    render('index');
});

/**
 * Sessions and login
 */
$app->get('/close_session', function () use ($app) {
    $_SESSION = [];
    $app->response->redirect('/create_session');
});

$app->get('/create_session', function () use ($app) {
    render('create_session', $_SESSION['flash']);
});

$app->post('/create_session', function () use ($app) {
    if (verify_admin($_POST, $error)) {
        create_session('ADMIN');
        return $app->response->redirect('/administrative_management');
    }
    $_SESSION['flash'] = array_select_keys($_POST, ['login','password']);
    $_SESSION['flash']['error'] = $error;
    return $app->response->redirect('/create_session');
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
