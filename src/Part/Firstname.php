<?php

namespace TheIconic\NameParser\Part;

class Firstname extends AbstractPart
{
    /**
     * camelcase the firstname
     *
     * @return string
     */
    public function normalize(): string
    {
        return $this->camelcase($this->getValue());
    }
}
