<?php

namespace TheIconic\NameParser;

class Factory
{
    public function createName(array $parts = []): Name
    {
        return new Name($parts);
    }
}
