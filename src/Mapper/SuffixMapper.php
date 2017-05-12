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
        if ($this->options['match_single'] && count($parts) == 1 && Suffix::isSuffix($parts[0])) {
            $parts[0] = new Suffix($parts[0]);
            return $parts;
        }

        $start = count($parts) - 1;

        for ($k = $start; $k > 1; $k--) {
            $part = $parts[$k];

            if ($part instanceof AbstractPart) {
                break;
            }

            if (Suffix::isSuffix($part)) {
                $parts[$k] = new Suffix($part);
            } else {
                break;
            }
        }

        return $parts;
    }
}
