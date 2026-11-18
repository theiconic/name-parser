<?php

declare(strict_types=1);

namespace TheIconic\NameParser;

use TheIconic\NameParser\Language\English;
use TheIconic\NameParser\Mapper\AbstractMapper;
use TheIconic\NameParser\Mapper\FirstnameMapper;
use TheIconic\NameParser\Mapper\InitialMapper;
use TheIconic\NameParser\Mapper\LastnameMapper;
use TheIconic\NameParser\Mapper\MiddlenameMapper;
use TheIconic\NameParser\Mapper\NicknameMapper;
use TheIconic\NameParser\Mapper\SalutationMapper;
use TheIconic\NameParser\Mapper\SuffixMapper;

class Parser
{
    protected string $whitespace = " \r\n\t";

    /**
     * @var AbstractMapper[]
     */
    protected array $mappers = [];

    /**
     * @var LanguageInterface[]
     */
    protected array $languages = [];

    /**
     * @var array<string, string> opening => closing delimiter
     */
    protected array $nicknameDelimiters = [];

    protected int $maxSalutationIndex = 0;

    protected int $maxCombinedInitials = 2;

    /**
     * @param LanguageInterface[] $languages defaults to English
     */
    public function __construct(array $languages = [])
    {
        $this->languages = $languages ?: [new English()];
    }

    /**
     * split full names into the following parts:
     * - prefix / salutation  (Mr., Mrs., etc)
     * - given name / first name
     * - middle initials
     * - surname / last name
     * - suffix (II, Phd, Jr, etc)
     */
    public function parse(string $name): Name
    {
        $name = $this->normalize($name);

        $segments = explode(',', $name);

        if (1 < count($segments)) {
            return $this->parseSplitName($segments[0], $segments[1], $segments[2] ?? '');
        }

        $parts = explode(' ', $name);

        foreach ($this->getMappers() as $mapper) {
            $parts = $mapper->map($parts);
        }

        return new Name($parts);
    }

    /**
     * handles split-parsing of comma-separated name parts
     *
     * @param string $first the name part left of the first comma
     * @param string $second the name part right of the first comma
     * @param string $third the name part right of the second comma
     */
    protected function parseSplitName(string $first, string $second, string $third): Name
    {
        $parts = array_merge(
            $this->getFirstSegmentParser()->parse($first)->getParts(),
            $this->getSecondSegmentParser()->parse($second)->getParts(),
            $this->getThirdSegmentParser()->parse($third)->getParts()
        );

        return new Name($parts);
    }

    protected function getFirstSegmentParser(): Parser
    {
        return (new Parser())->setMappers([
            new SalutationMapper($this->getSalutations(), $this->getMaxSalutationIndex()),
            new SuffixMapper($this->getSuffixes(), false, 2),
            new LastnameMapper($this->getPrefixes(), true),
            new FirstnameMapper(),
            new MiddlenameMapper(),
        ]);
    }

    protected function getSecondSegmentParser(): Parser
    {
        return (new Parser())->setMappers([
            new SalutationMapper($this->getSalutations(), $this->getMaxSalutationIndex()),
            new SuffixMapper($this->getSuffixes(), true, 1),
            new NicknameMapper($this->getNicknameDelimiters()),
            new InitialMapper($this->getMaxCombinedInitials(), true),
            new FirstnameMapper(),
            new MiddlenameMapper(true),
        ]);
    }

    protected function getThirdSegmentParser(): Parser
    {
        return (new Parser())->setMappers([
            new SuffixMapper($this->getSuffixes(), true, 0),
        ]);
    }

    /**
     * get the mappers for this parser
     *
     * @return AbstractMapper[]
     */
    public function getMappers(): array
    {
        if (empty($this->mappers)) {
            $this->setMappers([
                new NicknameMapper($this->getNicknameDelimiters()),
                new SalutationMapper($this->getSalutations(), $this->getMaxSalutationIndex()),
                new SuffixMapper($this->getSuffixes()),
                new InitialMapper($this->getMaxCombinedInitials()),
                new LastnameMapper($this->getPrefixes()),
                new FirstnameMapper(),
                new MiddlenameMapper(),
            ]);
        }

        return $this->mappers;
    }

    /**
     * set the mappers for this parser
     *
     * @param AbstractMapper[] $mappers
     */
    public function setMappers(array $mappers): static
    {
        $this->mappers = $mappers;

        return $this;
    }

    /**
     * normalize the name: trim and collapse whitespace into single spaces
     */
    protected function normalize(string $name): string
    {
        $whitespace = preg_quote($this->getWhitespace(), '/');

        return preg_replace('/[' . $whitespace . ']+/', ' ', trim($name));
    }

    /**
     * get a string of characters that are supposed to be treated as whitespace
     */
    public function getWhitespace(): string
    {
        return $this->whitespace;
    }

    /**
     * set the string of characters that are supposed to be treated as whitespace
     */
    public function setWhitespace(string $whitespace): static
    {
        $this->whitespace = $whitespace;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    protected function getPrefixes(): array
    {
        $prefixes = [];

        foreach ($this->languages as $language) {
            $prefixes += $language->getLastnamePrefixes();
        }

        return $prefixes;
    }

    /**
     * @return array<string, string>
     */
    protected function getSuffixes(): array
    {
        $suffixes = [];

        foreach ($this->languages as $language) {
            $suffixes += $language->getSuffixes();
        }

        return $suffixes;
    }

    /**
     * @return array<string, string>
     */
    protected function getSalutations(): array
    {
        $salutations = [];

        foreach ($this->languages as $language) {
            $salutations += $language->getSalutations();
        }

        return $salutations;
    }

    /**
     * @return array<string, string>
     */
    public function getNicknameDelimiters(): array
    {
        return $this->nicknameDelimiters;
    }

    /**
     * @param array<string, string> $nicknameDelimiters opening => closing delimiter
     */
    public function setNicknameDelimiters(array $nicknameDelimiters): static
    {
        $this->nicknameDelimiters = $nicknameDelimiters;

        return $this;
    }

    public function getMaxSalutationIndex(): int
    {
        return $this->maxSalutationIndex;
    }

    public function setMaxSalutationIndex(int $maxSalutationIndex): static
    {
        $this->maxSalutationIndex = $maxSalutationIndex;

        return $this;
    }

    public function getMaxCombinedInitials(): int
    {
        return $this->maxCombinedInitials;
    }

    public function setMaxCombinedInitials(int $maxCombinedInitials): static
    {
        $this->maxCombinedInitials = $maxCombinedInitials;

        return $this;
    }

    public function setLanguages(array $languages): static
    {
        $this->languages = $languages;

        return $this;
    }

    public function addLanguage(LanguageInterface $language): static
    {
        $this->languages[] = $language;

        return $this;
    }
}
