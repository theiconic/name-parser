<?php

namespace TheIconic\NameParser\Part;

class Lastname extends AbstractPart
{
    /**
     * @var array possible lastname prefixes
     */
    protected static $prefixes = [
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

    /** @var bool */
    private $applyPrefix = false;

    /**
     * check if the given word is a lastname prefix
     *
     * @param string $word the word to check
     * @return bool
     */
    public static function isPrefix($word): bool
    {
        return (array_key_exists(self::getKey($word), static::$prefixes));
    }

    /**
     * get the prefix registry key for the given word
     *
     * @param string $word the word
     * @return string the key
     */
    protected static function getKey($word): string
    {
        return strtolower(str_replace('.', '', $word));
    }

    /**
     * if this is a lastname prefix, look up normalized version from registry
     * otherwise camelcase the lastname
     *
     * @return string
     */
    public function normalize(): string
    {
        $value = $this->getValue();

        if ($this->applyPrefix && self::isPrefix($value)) {
            return static::$prefixes[self::getKey($value)];
        }

        return $this->camelcase($this->getValue());
    }

    /**
     * @param bool $applyPrefix
     * @return Lastname
     */
    public function setApplyPrefix(bool $applyPrefix): Lastname
    {
        $this->applyPrefix = $applyPrefix;

        return $this;
    }
}
