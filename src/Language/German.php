<?php

namespace TheIconic\NameParser\Language;

use TheIconic\NameParser\LanguageInterface;

class German implements LanguageInterface
{
    const SUFFIXES = [
        '1.' => '1.',
        '2.' => '2.',
        '3.' => '3.',
        '4.' => '4.',
        '5.' => '5.',
        'i' => 'I',
        'ii' => 'II',
        'iii' => 'III',
        'iv' => 'IV',
        'v' => 'V',
    ];

    const SALUTATIONS = [
        'herr' => 'Herr',
        'hr' => 'Herr',
        'frau' => 'Frau',
        'fr' => 'Frau'
    ];

    const LASTNAME_PREFIXES = [
        'der' => 'der',
        'von' => 'von',
    ];

    public function getSuffixes(): array
    {
        return self::SUFFIXES;
    }

    public function getSalutations(): array
    {
        return self::SALUTATIONS;
    }

    public function getLastnamePrefixes(): array
    {
        return self::LASTNAME_PREFIXES;
    }
}
