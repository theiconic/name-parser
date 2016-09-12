<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Suffix;

class LastnameMapper extends AbstractMapper
{

    /**
     * @var array options
     */
    protected $options = [
        'match_single' => false,
    ];

    /**
     * map lastnames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts) {
        if (!$this->options['match_single'] && count($parts) < 2) {
            return $parts;
        }

        if (count($parts) === 2 && $parts[0] instanceof AbstractPart) {
            $parts[1] = new Lastname($parts[1]);
        }

        $parts = array_reverse($parts);

        foreach ($parts as $k => $part) {
            if ($part instanceof Suffix) {
                continue;
            }

            if ($part instanceof AbstractPart) {
                break;
            }

            if (Lastname::isPrefix($part)) {
                if (isset($parts[$k-1]) && $parts[$k-1] instanceof Lastname ) {
                    if ($this->hasUnmappedPartsBefore(array_reverse($parts), count($parts) - $k - 1)) {
                        $parts[$k] = new Lastname($part);
                    }
                }
            } else if (!isset($parts[$k-1]) || !($parts[$k-1] instanceof Lastname)) {
                $parts[$k] = new Lastname($part);
            } else {
                break;
            }
        }

        return array_reverse($parts);
    }

    /**
     * checks if there are still unmapped parts left before the given position
     *
     * @param array $parts
     * @param $index
     * @return bool
     */
    protected function hasUnmappedPartsBefore(array $parts, $index)
    {
        foreach ($parts as $k => $part)
        {
            if ($k === $index) {
                break;
            }

            if (!($part instanceof AbstractPart)) {
                return true;
            }
        }

        return false;
    }

}
