<?php

namespace TheIconic\NameParser\Definition;

use TheIconic\NameParser\DefinitionInterface;

class Configurable implements DefinitionInterface
{
    private $salutations = [];
    private $suffixes = [];
    private $lastnamePrefixes = [];

    public function __construct(
        array $salutations,
        array $suffixes,
        array $lastnamePrefixes
    ) {
        $this->salutations = $this->sanitize($salutations);
        $this->suffixes = $this->sanitize($suffixes);
        $this->lastnamePrefixes = $this->sanitize($lastnamePrefixes);
    }

    public function addSalutations(array $salutations): void
    {
        $this->salutations = array_merge(
            $this->salutations,
            $this->sanitize($salutations)
        );
    }

    public function addSuffixes(array $suffixes): void
    {
        $this->suffixes = array_merge(
            $this->suffixes,
            $this->sanitize($suffixes)
        );
    }

    public function addLastnamePrefixes(array $lastnamePrefixes): void
    {
        $this->lastnamePrefixes = array_merge(
            $this->lastnamePrefixes,
            $this->sanitize($lastnamePrefixes)
        );
    }

    public function getSalutations(): array
    {
        return $this->salutations;
    }

    public function getSuffixes(): array
    {
        return $this->suffixes;
    }

    public function getLastnamePrefixes(): array
    {
        return $this->lastnamePrefixes;
    }

    private function sanitize(array $mappings): array
    {
        $sanitized = [];

        foreach ($mappings as $alias => $normalized) {
            $sanitized[strtolower($alias)] = $normalized;
        }

        return $sanitized;
    }
}
