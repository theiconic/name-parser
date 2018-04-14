<?php

namespace TheIconic\NameParser\Part;

class Initial extends AbstractPart
{
    /**
     * uppercase the initial
     *
     * @return string
     */
    public function normalize(): string
    {
        return strtoupper($this->getValue());
    }
}
