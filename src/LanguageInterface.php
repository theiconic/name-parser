<?php

namespace TheIconic\NameParser;

interface LanguageInterface
{
    public function getSuffixes(): array;

    public function getLastnamePrefixes(): array;

    public function getSalutations(): array;

    public function getExtensions(): array;

    public function getTitles(): array;

    public function getCompanies(): array;
}
