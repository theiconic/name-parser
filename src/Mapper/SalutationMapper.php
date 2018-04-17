<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Salutation;

class SalutationMapper extends AbstractMapper
{
    protected $salutations = [];

    public function __construct(array $salutations)
    {
        $this->salutations = $salutations;
    }

    /**
     * map salutations in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                break;
            }

            if ($this->isSalutation($part)) {
                $parts[$k] = new Salutation($part, $this->salutations[$this->getKey($part)]);
            }
        }

        return $parts;
    }

    /**
     * check if the given word is a viable salutation
     *
     * @param string $word the word to check
     * @return bool
     */
    protected function isSalutation($word): bool
    {
        return (array_key_exists($this->getKey($word), $this->salutations));
    }
}
