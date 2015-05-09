<?php

namespace TheIconic\NameParser\Mapper;

abstract class AbstractMapper
{

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

}
