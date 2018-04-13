<?php

namespace TheIconic\NameParser\Part;

class Lastname extends AbstractPart
{
    /**
     * @var array possible lastname prefixes
     */
    protected static $prefixes = [
        'vere' => 'vere',
        'von' => 'von',
        'van' => 'van',
        'de' => 'de',
        'der' => 'der',
        'del' => 'del',
        'della' => 'della',
        'di' => 'di',
        'da' => 'da',
        'pietro' => 'pietro',
        'vanden' => 'vanden',
        'du' => 'du',
        'st' => 'st.',
        'la' => 'la',
        'ter' => 'ter'
    ];
    /** @var bool */
    private $applyPrefix = false;

    /**
     * check if the given word is a lastname prefix
     *
     * @param string $word the word to check
     * @return bool
     */
    public static function isPrefix($word)
    {
        return (array_key_exists(self::getKey($word), static::$prefixes));
    }

    /**
     * get the prefix registry key for the given word
     *
     * @param string $word the word
     * @return string the key
     */
    protected static function getKey($word)
    {
        return strtolower(str_replace('.', '', $word));
    }

    /**
     * if this is a lastname prefix, look up normalized version from registry
     * otherwise camelcase the lastname
     *
     * @return mixed
     */
    public function normalize()
    {
        $value = $this->getValue();

        if ($this->applyPrefix && self::isPrefix($value)) {
            return static::$prefixes[self::getKey($value)];
        }

        return $this->camelcase($this->getValue());
    }

    /**
     * @param bool $applyPrefix
     */
    public function setApplyPrefix(bool $applyPrefix)
    {
        $this->applyPrefix = $applyPrefix;
    }
}
