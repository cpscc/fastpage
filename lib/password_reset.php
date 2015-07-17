<?php
function password_reset($email)
{
    $user = array_merge(user_fetch($email), ['token'=>str_rand()]);

    if (user_store($user) && (strpos($email, "@") !== false)) {
        $slug = explode('/',$_SERVER['REQUEST_URI'])[1];
        $model = ['app'=>APP, 'url'=>"http://$_SERVER[HTTP_HOST]/$slug/$user[token]"];
        email_send([
            'to'          => [['email' => $email]],
            'from_email'  => "noreply@cornerstone.cc",
            'from_name'   => APP,
            'subject'     => "Password Reset",
            'text'        => render("password_reset_email", $model, $as_string=false, $no_print=true),
        ]);
        return true;
    }
    return false;
}
