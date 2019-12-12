<?php

namespace TheIconic\NameParser;

if (!function_exists('TheIconic\NameParser\strlen')) {
    function strlen(string $string): int
    {
        return \strlen($string);
    }
}

if (!function_exists('TheIconic\NameParser\tcword')) {
    function tcword(string $string): string
    {
        return \ucfirst(\strtolower($string));
    }
}

if (!function_exists('TheIconic\NameParser\characters')) {
    function characters(string $string): array
    {
        return \str_split($string, $split_length = 1);
    }
}

if (!function_exists('TheIconic\NameParser\substr')) {
    function substr(string $string, int $start, int $length = null): string
    {
        return \substr($string, $start, $length);
    }
}
