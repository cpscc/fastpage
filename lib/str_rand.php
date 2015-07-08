<?php
/**
 * str_rand() - generate a pseudo-random string from a "human-friendly" character set
 */
function str_rand($length = 25)
{
    $chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefhjkmnprstuvwxyz23456789";
    return substr(str_shuffle(str_repeat($chars, rand(1,10))), 0, $length);
}
