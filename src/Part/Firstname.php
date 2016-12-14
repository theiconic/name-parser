<?php

namespace TheIconic\NameParser\Part;

class Firstname extends AbstractPart
{
    /**
     * camelcase the firstname
     *
     * @return mixed
     */
    public function normalize()
    {
        return $this->camelcase($this->getValue());
    }
}
