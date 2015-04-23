<?php
function render_keys($page)
{
    if (!is_array($page->_add_keys))
        return $page;

    foreach ($page->_add_keys as $bucket) {
        foreach ($page->$bucket as $k=>&$v) {
            $v->key = $k;
        }
    }
    return $page;
}
