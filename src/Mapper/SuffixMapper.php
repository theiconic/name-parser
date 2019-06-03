<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Suffix;

class SuffixMapper extends AbstractMapper
{
    protected $suffixes = [];

    protected $matchSinglePart = false;

    protected $reservedParts = 2;

    public function __construct(array $suffixes, bool $matchSinglePart = false, int $reservedParts = 2)
    {
        $this->suffixes = $suffixes;
        $this->matchSinglePart = $matchSinglePart;
        $this->reservedParts = $reservedParts;
    }

    /**
     * map suffixes in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        if ($this->isMatchingSinglePart($parts)) {
            $parts[0] = new Suffix($parts[0], $this->suffixes[$this->getKey($parts[0])]);
            return $parts;
        }

        $start = count($parts) - 1;

        for ($k = $start; $k > $this->reservedParts - 1; $k--) {
            $part = $parts[$k];

            if (!$this->isSuffix($part)) {
                break;
            }

            $parts[$k] = new Suffix($part, $this->suffixes[$this->getKey($part)]);
        }

        return $parts;
    }

    /**
     * @param $parts
     * @return bool
     */
    protected function isMatchingSinglePart($parts): bool
    {
        if (!$this->matchSinglePart) {
            return false;
        }

        if (1 !== count($parts)) {
            return false;
        }

        return $this->isSuffix($parts[0]);
    }

    /**
     * @param $part
     * @return bool
     */
    protected function isSuffix($part): bool
    {
        if ($part instanceof AbstractPart) {
            return false;
        }

        return (array_key_exists($this->getKey($part), $this->suffixes));
    }
}
