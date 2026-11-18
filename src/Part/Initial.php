<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Part;

class Initial extends GivenNamePart
{
    /**
     * uppercase the initial
     */
    public function normalize(): string
    {
        return strtoupper($this->getValue());
    }
}
