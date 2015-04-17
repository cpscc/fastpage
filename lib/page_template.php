<?php
function page_template($page)
{
    if (!empty($page->theme))
        return bin2hex($page->theme) . '_view';
    return 'default_view';
}
