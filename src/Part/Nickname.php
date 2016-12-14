<?php

namespace TheIconic\NameParser\Part;

class Nickname extends AbstractPart
{
    /**
     * camelcase the nickname for normalization
     *
     * @return mixed
     */
    public function normalize()
    {
        return $this->camelcase($this->getValue());
    }
}
