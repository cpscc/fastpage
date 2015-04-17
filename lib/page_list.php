<?php
function page_list()
{
    $pages = [];
    foreach (glob(root('pages/*.json')) as $p) {
        $pages[] = [
            'name'=>$n=substr(basename($p), 0, -5),
            'url'=>'/'.urlencode($n)];
    }
    return compact('pages');
}
