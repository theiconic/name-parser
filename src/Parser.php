<?php

namespace TheIconic\NameParser;

use TheIconic\NameParser\Language\English;
use TheIconic\NameParser\Mapper\NicknameMapper;
use TheIconic\NameParser\Mapper\SalutationMapper;
use TheIconic\NameParser\Mapper\SuffixMapper;
use TheIconic\NameParser\Mapper\InitialMapper;
use TheIconic\NameParser\Mapper\LastnameMapper;
use TheIconic\NameParser\Mapper\FirstnameMapper;
use TheIconic\NameParser\Mapper\MiddlenameMapper;
use TheIconic\NameParser\Mapper\CompanyMapper;
use TheIconic\NameParser\Mapper\ExtensionMapper;
use TheIconic\NameParser\Mapper\MultipartMapper;

class Parser
{
    /**
     * @var string
     */
    protected $whitespace = " \r\n\t";

    /**
     * @var array
     */
    protected $mappers = [];

    /**
     * @var array
     */
    protected $languages = [];

    /**
     * @var array
     */
    protected $nicknameDelimiters = [];

    /**
     * @var int
     */
    protected $maxSalutationIndex = 0;

    /**
     * @var int
     */
    protected $maxCombinedInitials = 2;

    public function __construct(array $languages = [])
    {
        if (empty($languages)) {
            $languages = [new English()];
        }

        $this->languages = $languages;
    }

    /**
     * split full names into the following parts:
     * - prefix / salutation  (Mr., Mrs., etc)
     * - given name / first name
     * - middle initials
     * - surname / last name
     * - suffix (II, Phd, Jr, etc)
     * - extension (Germany: nobility predicate is part of lastname)
     * - title (Germany: academic titles are usually used as name parts between salutation and given name)
     * - company (the string contains typical characteristics for a company name and is returned identically)
     *
     * @param string $name
     * @return Name
     */
    public function parse($name): Name
    {
        $name = $this->normalize($name);

        $segments = explode(',', $name);

        if (1 < count($segments)) {
            return $this->parseSplitName($segments[0], $segments[1], $segments[2] ?? '');
        } else {
            $mapped = $this->getCompany($name);
            if (count($mapped)) {
                return new Name($mapped);
            }
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
     * @param string $first - the name part left of the comma
     * @param string $second - the name part right of the comma
     * @param string $third
     * @return Name
     */
    protected function parseSplitName($first, $second, $third): Name
    {
        $parts = array_merge(
            $this->getFirstSegmentParser()->parse($first)->getParts(),
            $this->getSecondSegmentParser()->parse($second)->getParts(),
            $this->getThirdSegmentParser()->parse($third)->getParts()
        );

        return new Name($parts);
    }

    /**
     * @return Parser
     */
    protected function getFirstSegmentParser(): Parser
    {
        $parser = new Parser();

        $parser->setMappers([
            new ExtensionMapper($this->getSamples('Extensions')),
            new MultipartMapper($this->getSamples('Titles'), 'title'),
            new MultipartMapper($this->getSamples('LastnamePrefixes'), 'prefix'),
            new SalutationMapper($this->getSamples('Salutations'), $this->getMaxSalutationIndex()),
            new SuffixMapper($this->getSamples('Suffixes'), false, 2),
            new LastnameMapper($this->getSamples('LastnamePrefixes'), true),
            new FirstnameMapper(),
            new MiddlenameMapper(),
        ]);

        return $parser;
    }

    /**
     * @return Parser
     */
    protected function getSecondSegmentParser(): Parser
    {
        $parser = new Parser();

        $parser->setMappers([
            new ExtensionMapper($this->getSamples('Extensions')),
            new MultipartMapper($this->getSamples('Titles'), 'title'),
            new MultipartMapper($this->getSamples('LastnamePrefixes'), 'prefix'),
            new SalutationMapper($this->getSamples('Salutations'), $this->getMaxSalutationIndex()),
            new SuffixMapper($this->getSamples('Suffixes'), true, 1),
            new NicknameMapper($this->getNicknameDelimiters()),
            new InitialMapper($this->getMaxCombinedInitials(), true),
            new FirstnameMapper(),
            new MiddlenameMapper(true),
        ]);

        return $parser;
    }

    protected function getThirdSegmentParser(): Parser
    {
        $parser = new Parser();

        $parser->setMappers([
            new SuffixMapper($this->getSamples('Suffixes'), true, 0),
        ]);

        return $parser;
    }

    /**
     * get the mappers for this parser
     *
     * @return array
     */
    public function getMappers(): array
    {
        if (empty($this->mappers)) {
            $this->setMappers([
                new ExtensionMapper($this->getSamples('Extensions')),
                new MultipartMapper($this->getSamples('Titles'), 'title'),
                new MultipartMapper($this->getSamples('LastnamePrefixes'), 'prefix'),
                new NicknameMapper($this->getNicknameDelimiters()),
                new SalutationMapper($this->getSamples('Salutations'), $this->getMaxSalutationIndex()),
                new SuffixMapper($this->getSamples('Suffixes')),
                new InitialMapper($this->getMaxCombinedInitials()),
                new LastnameMapper($this->getSamples('LastnamePrefixes')),
                new FirstnameMapper(),
                new MiddlenameMapper(),
            ]);
        }

        return $this->mappers;
    }

    /**
     * get name as company if parts matches company identifiers
     *
     * @param string $name
     * @return array
     */
    protected function getCompany(string $name): array
    {
        $mapper = new CompanyMapper($this->getSamples('Companies'));

        return $mapper->map([$name]);
    }

    /**
     * set the mappers for this parser
     *
     * @param array $mappers
     * @return Parser
     */
    public function setMappers(array $mappers): Parser
    {
        $this->mappers = $mappers;

        return $this;
    }

    /**
     * normalize the name
     *
     * @param string $name
     * @return string
     */
    protected function normalize(string $name): string
    {
        $whitespace = $this->getWhitespace();

        $name = trim($name);

        return preg_replace('/[' . preg_quote($whitespace) . ']+/', ' ', $name);
    }

    /**
     * get a string of characters that are supposed to be treated as whitespace
     *
     * @return string
     */
    public function getWhitespace(): string
    {
        return $this->whitespace;
    }

    /**
     * set the string of characters that are supposed to be treated as whitespace
     *
     * @param string $whitespace
     * @return Parser
     */
    public function setWhitespace($whitespace): Parser
    {
        $this->whitespace = $whitespace;

        return $this;
    }

    /**
     * @return array
     */
    protected function getSamples(string $sampleName): array
    {
        $samples = [];
        $method = sprintf('get%s', $sampleName);
        foreach ($this->languages as $language) {
            $samples += call_user_func_array([$language, $method], []);
        }

        return $samples;
    }

    /**
     * @return array
     */
    public function getNicknameDelimiters(): array
    {
        return $this->nicknameDelimiters;
    }

    /**
     * @param array $nicknameDelimiters
     * @return Parser
     */
    public function setNicknameDelimiters(array $nicknameDelimiters): Parser
    {
        $this->nicknameDelimiters = $nicknameDelimiters;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxSalutationIndex(): int
    {
        return $this->maxSalutationIndex;
    }

    /**
     * @param int $maxSalutationIndex
     * @return Parser
     */
    public function setMaxSalutationIndex(int $maxSalutationIndex): Parser
    {
        $this->maxSalutationIndex = $maxSalutationIndex;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxCombinedInitials(): int
    {
        return $this->maxCombinedInitials;
    }

    /**
     * @param int $maxCombinedInitials
     * @return Parser
     */
    public function setMaxCombinedInitials(int $maxCombinedInitials): Parser
    {
        $this->maxCombinedInitials = $maxCombinedInitials;

        return $this;
    }
}
