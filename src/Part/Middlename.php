<?php

namespace TheIconic\NameParser\Part;

class Middlename extends AbstractPart
{
    /**
     * camelcase the middlename for normalization
     *
     * @return string
     */
    public function normalize(): string
    {
        return $this->camelcase($this->getValue());
    }
}
