<?php

namespace TheIconic\NameParser\Part;

class Fullgivenname extends AbstractPart
{
    /**
     * camelcase thegivenname for normalization
     *
     * @return string
     */
    public function normalize(): string
    {
        return $this->camelcase($this->getValue());
    }
}
