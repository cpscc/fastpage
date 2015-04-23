<?php
function authenticate(\Slim\Slim $app)
{
    if (!authenticated()) $app->response->redirect('/create_session');
}
