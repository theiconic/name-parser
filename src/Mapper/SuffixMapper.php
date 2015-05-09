<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Suffix;

class SuffixMapper extends AbstractMapper
{

    /**
     * map suffixes in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    function map(array $parts) {
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
