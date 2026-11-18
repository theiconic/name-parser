<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Language;

use TheIconic\NameParser\LanguageInterface;

class Spanish implements LanguageInterface
{
    public const SUFFIXES = [
        'i' => 'I',
        'ii' => 'II',
        'iii' => 'III',
        'iv' => 'IV',
        'v' => 'V',
        'jr' => 'Jr.',
        'hijo' => 'hijo',
    ];

    public const SALUTATIONS = [
        'señor' => 'Señor',
        'sr' => 'Sr.',
        'señora' => 'Señora',
        'sra' => 'Sra.',
        'señorita' => 'Señorita',
        'srta' => 'Srta.',
        'don' => 'Don',
        'doña' => 'Doña',
        'dr' => 'Dr.',
        'dra' => 'Dra.',
        'lic' => 'Lic.',
        'licda' => 'Licda.',
        'ing' => 'Ing.',
        'prof' => 'Prof.',
        'profa' => 'Profa.',
    ];

    public const LASTNAME_PREFIXES = [
        'de' => 'de',
        'del' => 'del',
        'la' => 'la',
        'las' => 'las',
        'los' => 'los',
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
