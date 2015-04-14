<?php

function root($file = null)
{
    return $file ? dirname(__FILE__) . "/" . $file : dirname(__FILE__);
}

function initialize_repo($repo_name)
{
    # If the file doesn't exist, copy an "example"
    # If the example doesn't exist, create an empty file

    if (!file_exists($f=root("$repo_name.yaml"))) {
        if (file_exists($example=root("public/{$repo_name}_example.yaml")))
            return copy($example, $f);
        else
            return file_put_contents($f, "") !== false;
    }

    return true;
}

function store_repo($repo_name, $data)
{
    return file_put_contents(root("$repo_name.yaml", $data)) !== false;
}

function load_repo($repo_name)
{
    if ($r = file_get_contents(root("$repo_name.yaml")))
        return $r;
    else
        throw new RuntimeException("Could not find file: \"$repo_name.yaml\"");
}

function open_repo($repo_name)
{
    return parse_yaml(load_repo($repo_name));
}

function authenticated()
{
    return isset($_SESSION['AUTHENTICATED']) || isset($_SESSION['ADMIN']);
}

function admin()
{
    return isset($_SESSION['ADMIN']);
}

function create_session($name = 'AUTHENTICATED')
{
    return $_SESSION[$name] = true;
}

function verify_promo_code($code, &$error = null)
{
    $codes = open_repo('promo_codes');

    foreach ($codes as $c) {
        if (strtolower($c) == strtolower($code))
            return true;
    }

    $error = "Invalid Promo Code: $code";
    return false;
}

function verify_admin($user, &$error = null)
{
    $users = open_repo('users');

    foreach ($users as $u) {
        if ($u['login'] != trim($user['login']))
            continue;

        if ($u['password'] != $user['password']) {
            $error = "Invalid password";
            return false;
        }

        return true;
    }

    $error = "Unable to find login: {$user['login']}";
    return false;
}

function update_links($data, &$error = null)
{
    $p = parse_yaml($data, $error);
    if ($error) {
        return false;
    }
    return store_repo('links', $data);
}

function render($view, array $model = [], $string_loader = false)
{
    $view = THEME . '/' . $view;

    $options = array( 
        'pragmas'         => [Mustache_Engine::PRAGMA_FILTERS, Mustache_Engine::PRAGMA_BLOCKS],
        'loader'          => new Mustache_Loader_FilesystemLoader(root('views')),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(root('views')),
    );

    if ($string_loader)
        unset($options['loader']);

    print (new Mustache_Engine($options))->render($view, $model);

    unset($_SESSION['flash']);
}

function parse_yaml($string, &$error = null)
{
    $yaml = new Symfony\Component\Yaml\Parser();
    try {
        $value = $yaml->parse($string);
        return $value;
    } catch (Symfony\Component\Yaml\Exception\ParseException $e) {
        $error = "Unable to parse the YAML string: " . $e->getMessage();
        return false;
    }
}

function array_select_keys(array $dict, array $keys)
{
    $result = array();
    foreach ($keys as $key) {
        if (array_key_exists($key, $dict)) {
            $result[$key] = $dict[$key];
        }
    }
    return $result;
}
