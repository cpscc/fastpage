<?php
function page_template($page)
{
    if (!empty($page->theme))
        return $page->theme . '_view';
    return 'default_view';
}
