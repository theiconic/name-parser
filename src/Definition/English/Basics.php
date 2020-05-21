<?php

namespace TheIconic\NameParser\Definition\English;

use TheIconic\NameParser\DefinitionInterface;

class Basics implements DefinitionInterface
{
    const SUFFIXES = [
        '1st' => '1st',
        '2nd' => '2nd',
        '3rd' => '3rd',
        '4th' => '4th',
        '5th' => '5th',
        'i' => 'I',
        'ii' => 'II',
        'iii' => 'III',
        'iv' => 'IV',
        'v' => 'V',
        'apr' => 'APR',
        'cme' => 'CME',
        'dds' => 'DDS',
        'dmd' => 'DMD',
        'dvm' => 'DVM',
        'esq' => 'Esq',
        'jr' => 'Jr',
        'junior' => 'Junior',
        'ma' => 'MA',
        'md' => 'MD',
        'pe' => 'PE',
        'phd' => 'PhD',
        'rph' => 'RPh',
        'senior' => 'Senior',
        'sr' => 'Sr',
    ];

    const SALUTATIONS = [
        'dame' => 'Dame',
        'dr' => 'Dr.',
        'fr' => 'Fr.',
        'lady' => 'Lady',
        'lord' => 'Lord',
        'madam' => 'Madam',
        'master' => 'Mr.',
        'miss' => 'Miss',
        'mister' => 'Mr.',
        'mr' => 'Mr.',
        'mrs' => 'Mrs.',
        'ms' => 'Ms.',
        'mx' => 'Mx.',
        'pastor' => 'Pr.',
        'pr' => 'Pr.',
        'rev' => 'Rev.',
        'reverend' => 'Rev.',
        'rt hon' => 'Rt. Hon.',
        'sir' => 'Sir',
        'prof' => 'Prof.',
        'professor' => 'Prof.',
        'his honour' => 'His Honour',
        'her honour' => 'Her Honour'
    ];

    const LASTNAME_PREFIXES = [
        'da' => 'da',
        'de' => 'de',
        'del' => 'del',
        'della' => 'della',
        'der' => 'der',
        'di' => 'di',
        'du' => 'du',
        'la' => 'la',
        'pietro' => 'pietro',
        'st' => 'st.',
        'ter' => 'ter',
        'van' => 'van',
        'vanden' => 'vanden',
        'vere' => 'vere',
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
