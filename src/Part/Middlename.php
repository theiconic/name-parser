<?php

namespace TheIconic\NameParser\Part;

class Middlename extends AbstractPart
{
    /**
     * camelcase the middlename for normalization
     *
     * @return mixed
     */
    public function normalize()
    {
        return $this->camelcase($this->getValue());
    }
}
