<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\Salutation;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Lastname;

class SalutationMapperTest extends AbstractMapperTest
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
                    'Pan',
                ],
                'expectation' => [
                    new Salutation('Mr.'),
                    'Pan',
                ],
            ],
            [
                'input' => [
                    'Mr',
                    'Peter',
                    'Pan',
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    'Peter',
                    'Pan',
                ],
            ],
            [
                'input' => [
                    'Mr',
                    new Firstname('James'),
                    'Miss',
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    new Firstname('James'),
                    'Miss',
                ],
            ],
        ];
    }
}
