<?php
function template_list()
{
    $templates = [];
    foreach (glob(root('templates/*_view.mustache')) as $p) {
        $templates[] = [
            'name'=>$n=template_name(substr(basename($p), 0, -14)),
            'url'=>'/templates/'.urlencode($n)];
    }
    return compact('templates');
}

