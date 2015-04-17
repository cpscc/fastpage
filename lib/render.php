<?php
function render($view, array $model = [], $string_loader = false)
{
    $options = array( 
        'pragmas'         => [Mustache_Engine::PRAGMA_FILTERS, Mustache_Engine::PRAGMA_BLOCKS],
        'loader'          => new Mustache_Loader_FilesystemLoader(root(VIEWS)),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(root(VIEWS)),
    );

    if ($string_loader)
        unset($options['loader']);

    $model += (array)$_SESSION['flash'];
    $_SESSION['flash'] = [];

    print (new Mustache_Engine($options))->render($view, $model);
}

