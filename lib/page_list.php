<?php
function page_list($opts)
{
    $pages = [];
    foreach (glob(root('pages/*.json')) as $p) {
        $name = $n=substr(basename($p), 0, -5);
        $url  = '/'.urlencode($n);
        
        $list_page = (isset($opts['login'])) ? user_has_permission($opts['login'], $name) : true;

        if ($list_page) {
            $pages[] = compact('name','url');
        }
    }
    return compact('pages');
}
