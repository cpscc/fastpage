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
        create_session($user['role'], $user['login']);
        return $app->response->redirect('/pages');
    }
    $_SESSION['flash'] = array_select_keys($_POST, ['login','password']);
    $_SESSION['flash']['alert'] = $error;
    return $app->response->redirect('/create_session');
});

$app->get('/password_reset', function () use ($app) {
    render('password_reset', $_SESSION['flash']);
});

$app->post('/password_reset', function () use ($app) {
    if ($x = user_exists($_POST['email']) && password_reset($_POST['email'])) {
        $_SESSION['flash']['success'] = "A password reset has been sent to your email address. Please check your email.";
    } else {
        $_SESSION['flash'] = array_select_keys($_POST, ['email']);
        $_SESSION['flash']['alert'] = "Unable to find that email address in our system";
    }
    return $app->response->redirect("/password_reset");
});

$app->get('/password_reset/:token', function ($token) use ($app) {
    $token_verified = user_verify_token($token);
    render('password_update', (array)$_SESSION['flash'] + compact('token_verified', 'token'));
});

$app->post('/password_reset/:token', function ($token) use ($app) {
    if (!user_verify_token($token))
        return $app->response->redirect("/password_reset/$token");

    if (!empty($_POST['password']) && $_POST['password'] == $_POST['_password']) {
        $user = array_merge(user_by_token($token), ['token'=>'','password'=>$_POST['password']]);
        user_store($user);
        $_SESSION['flash']['success'] = "Your password has been successfully updated.";
        create_session($user['role'], $user['login']);
        return $app->response->redirect('/pages');
    }
    $_SESSION['flash'] = array_select_keys($_POST, ['password', '_password']);
    $_SESSION['flash']['alert'] = "The passwords do not match";
    return $app->response->redirect("/password_reset/$token");
});

$app->get('/not_allowed', function () use ($app) {
    render('not_allowed');
});


/**
 * User Dashboard
 * XXX: needs to actually allow managing users
 */
$app->get('/users/create', function () use ($app) {
    authenticate_admin($app);
    render('user_x', template_list());
});
$app->post('/users/create', function () use ($app) {
    authenticate_admin($app);
    user_store($_REQUEST);
    $_SESSION['flash']['success'] = "Created User " . $_REQUEST['login'];
    $app->response->redirect('/users/create');
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

    $opts = [];
    if (!admin()) $opts['login'] = current_user();

    render('pages', page_list($opts));
});

$app->get('/pages/create', function ($name) use ($app) {
    authenticate($app);

    render('page_x', ['create'=>true] + template_list());
});

$app->get('/pages/:name', function ($name) use ($app) {
    authenticate($app);

    $page = page_fetch($name);

    if ($page) {
        $model = ['page'=>render_keys($page)] + compact('name');

        $model['editing_template'] =
            render(name_encode($page->theme)."_edit", $model, false, true);

        $model['permissions'] = permissions_fetch($name);
    } else {
        $model = ['alert'=>'Could not find page'];
    }

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
        if (!$name)
            $app->response->redirect('/pages/create');
        else
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
