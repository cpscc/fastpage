<?php
function page_template($page)
{
    if (!empty($page->theme))
        return name_encode($page->theme) . '_view';
    return 'default_view';
}
