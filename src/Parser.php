<?php

namespace TheIconic\NameParser;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Mapper\SalutationMapper;
use TheIconic\NameParser\Mapper\SuffixMapper;
use TheIconic\NameParser\Mapper\InitialMapper;
use TheIconic\NameParser\Mapper\LastnameMapper;
use TheIconic\NameParser\Mapper\FirstnameMapper;

class Parser
{

    protected $whitespace = " \r\n\t";

    protected $mappers = [];

    public function init()
    {
        $this->setMappers([
            new SalutationMapper(),
            new SuffixMapper(),
            new InitialMapper(),
            new LastnameMapper(),
            new FirstnameMapper()
        ]);
    }

    /**
     * split full names into the following parts:
     * - prefix / salutation  (Mr., Mrs., etc)
     * - given name / first name
     * - middle initials
     * - surname / last name
     * - suffix (II, Phd, Jr, etc)
     *
     * @param $full_name
     * @return mixed
     */
    public function parse($name) {

        $name = $this->normalize($name);

        $parts = explode(' ', $name);

        $parts = $this->filter($parts);

        foreach ($this->getMappers() as $mapper) {
            $parts = $mapper->map($parts);
        }

        return new Name($parts);
    }

    public function getMappers()
    {
        return $this->mappers;
    }

    public function setMappers(array $mappers)
    {
        $this->mappers = $mappers;
    }

    protected function normalize($name)
    {
        $whitespace = $this->getWhitespace();

        if (false !== $pos = strpos($name, ',')) {
            $name = sprintf('%s %s', substr($name, $pos + 1), substr($name, 0, $pos));
        }

        $name = trim($name);

        return preg_replace('/[' . preg_quote($whitespace) . ']+/', ' ', $name);
    }

    protected function getWhitespace()
    {
        return $this->whitespace;
    }

    protected function setWhitespace($whitespace)
    {
        $this->whitespace = $whitespace;
    }

    protected function filter($parts)
    {
        $filtered = [];

        foreach ($parts as $part) {
            if (preg_match('/[\(\[\<\{].*[\)\]\>\}]/', $part)) {
                continue;
            }

            $filtered[] = $part;
        }

        return $filtered;
    }
}
