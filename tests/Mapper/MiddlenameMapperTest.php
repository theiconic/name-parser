<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\Salutation;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Middlename;
use TheIconic\NameParser\Part\Lastname;

class MiddlenameMapperTest extends AbstractMapperTest
{
    /**
     * @return array
     */
    public function provider()
    {
        return [
            [
                'input' => [
                    new Firstname('Peter'),
                    'Fry',
                    new Lastname('Pan'),
                ],
                'expectation' => [
                    new Firstname('Peter'),
                    new Middlename('Fry'),
                    new Lastname('Pan'),
                ],
            ],
            [
                'input' => [
                    new Firstname('John'),
                    'Albert',
                    'Tiberius',
                    new Lastname('Brown'),
                ],
                'expectation' => [
                    new Firstname('John'),
                    new Middlename('Albert'),
                    new Middlename('Tiberius'),
                    new Lastname('Brown'),
                ],
            ],
        ];
    }
}
