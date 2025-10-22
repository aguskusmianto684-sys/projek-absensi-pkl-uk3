<?php
if (!function_exists('escapeString')) {
    function escapeString($text): string
    {
        global $connect;
        return $connect->real_escape_string(string: $text);
    }
}
