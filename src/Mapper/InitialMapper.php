<?php

declare(strict_types=1);

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Initial;

/**
 * single letter, possibly followed by a period
 */
class InitialMapper extends AbstractMapper
{
    /**
     * @param int $combinedMax maximum number of combined initials to split up (e.g. "JM" => "J", "M")
     * @param bool $matchLastPart whether the last part may be mapped as an initial
     */
    public function __construct(
        private readonly int $combinedMax = 2,
        protected readonly bool $matchLastPart = false,
    ) {
    }

    /**
     * map intials in parts array
     *
     * @param array<int, AbstractPart|string> $parts the name parts
     * @return array<int, AbstractPart|string> the mapped parts
     */
    public function map(array $parts): array
    {
        $last = count($parts) - 1;

        for ($k = 0; $k < count($parts); $k++) {
            $part = $parts[$k];

            if ($part instanceof AbstractPart) {
                continue;
            }

            if (!$this->matchLastPart && $k === $last) {
                continue;
            }

            if (strtoupper($part) === $part) {
                $stripped = str_replace('.', '', $part);
                $length = strlen($stripped);

                if (1 < $length && $length <= $this->combinedMax) {
                    array_splice($parts, $k, 1, str_split($stripped));
                    $last = count($parts) - 1;
                    $part = $parts[$k];
                }
            }

            if ($this->isInitial($part)) {
                $parts[$k] = new Initial($part);
            }
        }

        return $parts;
    }

    protected function isInitial(string $part): bool
    {
        $length = strlen($part);

        if (1 === $length) {
            return true;
        }

        return $length === 2 && str_ends_with($part, '.');
    }
}
