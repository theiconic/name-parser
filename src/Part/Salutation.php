<?php

namespace TheIconic\NameParser\Part;

class Salutation extends AbstractPart
{
    /**
     * @var array possible salutations
     */
    protected static $salutations = [
        'dr' => 'Dr.',
        'fr' => 'Fr.',
        'madam' => 'Madam',
        'master' => 'Mr.',
        'miss' => 'Miss',
        'mister' => 'Mr.',
        'mr' => 'Mr.',
        'mrs' => 'Mrs.',
        'ms' => 'Ms.',
        'mx' => 'Mx.',
        'rev' => 'Rev.',
        'sir' => 'Sir',
    ];

    /**
     * check if the given word is a viable salutation
     *
     * @param string $word the word to check
     * @return bool
     */
    public static function isSalutation($word): bool
    {
        return (array_key_exists(self::getKey($word), static::$salutations));
    }

    /**
     * get the registry lookup key for the given word
     *
     * @param string $word the word
     * @return string the key
     */
    protected static function getKey($word): string
    {
        return strtolower(str_replace('.', '', $word));
    }

    /**
     * normalize by looking up the wrapped value against the registry
     *
     * @return string
     */
    public function normalize(): string
    {
        return static::$salutations[self::getKey($this->getValue())];
    }
}
