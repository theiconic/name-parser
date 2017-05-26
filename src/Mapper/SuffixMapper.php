<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Suffix;

class SuffixMapper extends AbstractMapper
{
    /**
     * @var array options
     */
    protected $options = [
        'match_single' => false,
    ];

    /**
     * map suffixes in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts)
    {
        if ($this->isMatchingSinglePart($parts)) {
            $parts[0] = new Suffix($parts[0]);
            return $parts;
        }

        $start = count($parts) - 1;

        for ($k = $start; $k > 1; $k--) {
            $part = $parts[$k];

            if (!$this->isSuffix($part)) {
                break;
            }

            $parts[$k] = new Suffix($part);
        }

        return $parts;
    }

    /**
     * @param $parts
     * @return bool
     */
    protected function isMatchingSinglePart($parts)
    {
        if (!$this->options['match_single']) {
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

        return (Suffix::isSuffix($part));
    }
}
