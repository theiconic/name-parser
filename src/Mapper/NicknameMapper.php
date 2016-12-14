<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Nickname;

class NicknameMapper extends AbstractMapper
{
    /**
     * map nicknames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    function map(array $parts) {
        $isEncapsulated = false;

        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                continue;
            }

            if (preg_match('/^[\(\[\<\{]/', $part)) {
                $isEncapsulated = true;

                $part = substr($part, 1);
            }

            $addPart = $isEncapsulated;

            if (preg_match('/[\)\]\>\}]$/', $part)) {
                $isEncapsulated = false;
                $part = substr($part, 0, -1);
            }

            if ($addPart) {
                $parts[$k] = new Nickname($part);
            }
        }

        return $parts;
    }
}
