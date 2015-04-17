<?php
function template_list()
{
    $templates = [];
    foreach (glob(root('templates/*_view.mustache')) as $p) {
        $templates[] = [
            'name'=>$n=name_decode(substr(basename($p), 0, -14)),
            'url'=>'/templates/'.urlencode($n)];
    }
    return compact('templates');
}

