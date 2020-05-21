<?php

namespace TheIconic\NameParser;

interface DefinitionInterface
{
    public function getSuffixes(): array;

    public function getLastnamePrefixes(): array;

    public function getSalutations(): array;
}
