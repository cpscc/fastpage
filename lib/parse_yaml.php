<?php
function parse_yaml($string, &$error = null)
{
    $yaml = new Symfony\Component\Yaml\Parser();
    try {
        $value = $yaml->parse($string);
        return $value;
    } catch (Symfony\Component\Yaml\Exception\ParseException $e) {
        $error = "Unable to parse the YAML string: " . $e->getMessage();
        return false;
    }
}

