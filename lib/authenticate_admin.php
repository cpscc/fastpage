<?php
function authenticate_admin(\Slim\Slim $app)
{
    if (!authenticated()) return $app->response->redirect('/create_session');
    if (!admin()) return $app->response->redirect('/not_allowed');
}
