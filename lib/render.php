<?php
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

    $model['authenticated'] = authenticated();

    print (new Mustache_Engine($options))->render($view, $model);

    unset($_SESSION['flash']);
}

