<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Nickname;

// single letter, possibly followed by a period
class NicknameMapper extends AbstractMapper
{

    /**
     * map nicknames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    function map(array $parts) {
        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                continue;
            }

            if (preg_match('/^[\(\[\<\{].*[\)\]\>\}]$/', $part)) {
                $parts[$k] = new Nickname(substr($part, 1, -1));
            }
        }

        return $parts;
    }

}
