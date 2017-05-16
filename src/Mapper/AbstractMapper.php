<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;

abstract class AbstractMapper
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * constructor allows passing of options
     *
     * @param array $options
     */
    public function __construct(array $options = null)
    {
        if (null !== $options) {
            $this->options = array_merge($this->options, $options);
        }
    }

    /**
     * implements the mapping of parts
     *
     * @param array $parts - the name parts
     * @return array $parts - the mapped parts
     */
    abstract public function map(array $parts);

    /**
     * checks if there are still unmapped parts left before the given position
     *
     * @param array $parts
     * @param $index
     * @return bool
     */
    protected function hasUnmappedPartsBefore(array $parts, $index)
    {
        foreach ($parts as $k => $part) {
            if ($k === $index) {
                break;
            }

            if (!($part instanceof AbstractPart)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $type
     * @param array $parts
     * @return int|bool
     */
    protected function findFirstMapped(string $type, array $parts)
    {
        $total = count($parts);

        for ($i = 0; $i < $total; $i++) {
            if ($parts[$i] instanceof $type) {
                return $i;
            }
        }

        return false;
    }
}
