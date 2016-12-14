<?php

namespace TheIconic\NameParser\Part;

class Initial extends AbstractPart
{
    /**
     * uppercase the initial
     *
     * @return mixed
     */
    public function normalize()
    {
        return strtoupper($this->getValue());
    }
}
