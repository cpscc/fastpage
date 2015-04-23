<?php
function repo_open($repo_name)
{
    return parse_yaml(repo_load($repo_name));
}
