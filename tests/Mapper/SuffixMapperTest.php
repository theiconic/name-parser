<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Language\English;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Suffix;

class SuffixMapperTest extends AbstractMapperTest
{
    /**
     * @return array
     */
    public function provider()
    {
        return [
            [
                'input' => [
                    'Mr.',
                    'James',
                    'Blueberg',
                    'PhD',
                ],
                'expectation' => [
                    'Mr.',
                    'James',
                    'Blueberg',
                    new Suffix('PhD'),
                ],
                [
                    'matchSinglePart' => false,
                    'reservedParts' => 2,
                ]
            ],
            [
                'input' => [
                    'Prince',
                    'Alfred',
                    'III',
                ],
                'expectation' => [
                    'Prince',
                    'Alfred',
                    new Suffix('III'),
                ],
                [
                    'matchSinglePart' => false,
                    'reservedParts' => 2,
                ]
            ],
            [
                'input' => [
                    new Firstname('Paul'),
                    new Lastname('Smith'),
                    'Senior',
                ],
                'expectation' => [
                    new Firstname('Paul'),
                    new Lastname('Smith'),
                    new Suffix('Senior'),
                ],
                [
                    'matchSinglePart' => false,
                    'reservedParts' => 2,
                ]
            ],
            [
                'input' => [
                    'Senior',
                    new Firstname('James'),
                    'Norrington',
                ],
                'expectation' => [
                    'Senior',
                    new Firstname('James'),
                    'Norrington',
                ],
                [
                    'matchSinglePart' => false,
                    'reservedParts' => 2,
                ]
            ],
            [
                'input' => [
                    'Senior',
                    new Firstname('James'),
                    new Lastname('Norrington'),
                ],
                'expectation' => [
                    'Senior',
                    new Firstname('James'),
                    new Lastname('Norrington'),
                ],
                [
                    'matchSinglePart' => false,
                    'reservedParts' => 2,
                ]
            ],
            [
                'input' => [
                    'James',
                    'Norrington',
                    'Senior',
                ],
                'expectation' => [
                    'James',
                    'Norrington',
                    new Suffix('Senior'),
                ],
                [
                    false,
                    2,
                ]
            ],
            [
                'input' => [
                    'Norrington',
                    'Senior',
                ],
                'expectation' => [
                    'Norrington',
                    'Senior',
                ],
                [
                    false,
                    2,
                ]
            ],
            [
                'input' => [
                    new Lastname('Norrington'),
                    'Senior',
                ],
                'expectation' => [
                    new Lastname('Norrington'),
                    new Suffix('Senior'),
                ],
                [
                    false,
                    1,
                ]
            ],
            [
                'input' => [
                    'Senior',
                ],
                'expectation' => [
                    new Suffix('Senior'),
                ],
                [
                    true,
                ]
            ],
        ];
    }

    protected function getMapper($matchSinglePart = false, $reservedParts = 2)
    {
        $english = new English();

        return new SuffixMapper($english->getSuffixes(), $matchSinglePart, $reservedParts);
    }
}
