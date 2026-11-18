<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Nickname;

class NicknameMapper extends AbstractMapper
{
    /**
     * @var array<string, string> opening => closing delimiter
     */
    protected array $delimiters = [
        '[' => ']',
        '{' => '}',
        '(' => ')',
        '<' => '>',
        '"' => '"',
        '\'' => '\'',
    ];

    /**
     * @param array<string, string> $delimiters opening => closing delimiter, defaults are used when empty
     */
    public function __construct(array $delimiters = [])
    {
        if (!empty($delimiters)) {
            $this->delimiters = $delimiters;
        }
    }

    /**
     * map nicknames in the parts array
     *
     * @param array<int, AbstractPart|string> $parts the name parts
     * @return array<int, AbstractPart|string> the mapped parts
     */
    public function map(array $parts): array
    {
        $isEncapsulated = false;

        $regexp = $this->buildRegexp();

        $closingDelimiter = '';

        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                continue;
            }

            if (preg_match($regexp, $part, $matches)) {
                $isEncapsulated = true;
                $part = substr($part, 1);
                $closingDelimiter = $this->delimiters[$matches[1]];
            }

            if (!$isEncapsulated) {
                continue;
            }

            if (str_ends_with($part, $closingDelimiter)) {
                $isEncapsulated = false;
                $part = substr($part, 0, -1);
            }

            $parts[$k] = new Nickname(str_replace(['"', '\''], '', $part));
        }

        return $parts;
    }

    protected function buildRegexp(): string
    {
        $regexp = '/^([';

        foreach (array_keys($this->delimiters) as $opening) {
            $regexp .= sprintf('\\%s', $opening);
        }

        $regexp .= '])/';

        return $regexp;
    }
}
