<?php
/**
 * @param string $string
 * @return mixed
 */
function stringToSlug(string $string)
{
    return str_replace([' ', '_'], '-', $string);
}