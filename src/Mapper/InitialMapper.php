<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Initial;

/**
 * single letter, possibly followed by a period
 */
class InitialMapper extends AbstractMapper
{
    /**
     * map intials in parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    function map(array $parts) {
        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                continue;
            }

            if ((strlen($part) == 1) || (strlen($part) == 2 && substr($part, -1) ===  '.')) {
                $parts[$k] = new Initial($part);
            }
        }

        return $parts;
    }
}
