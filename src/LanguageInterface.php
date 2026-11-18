<?php

declare(strict_types=1);

namespace TheIconic\NameParser;

interface LanguageInterface
{
    /**
     * @return array<string, string> lowercase lookup key => normalized suffix
     */
    public function getSuffixes(): array;

    /**
     * @return array<string, string> lowercase lookup key => normalized prefix
     */
    public function getLastnamePrefixes(): array;

    /**
     * @return array<string, string> lowercase lookup key => normalized salutation
     */
    public function getSalutations(): array;
}
