<?php

namespace TheIconic\NameParser;

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @return array
     */
    public function provider()
    {
        return [
            [
                'James Norrington',
                [
                    'firstname' => 'James',
                    'lastname' => 'Norrington',
                ]

            ],
            [
                'Hans Christian Anderssen',
                [
                    'firstname' => 'Hans',
                    'lastname' => 'Anderssen',
                    'middlename' => 'Christian',
                ]
            ],
            [
                'Mr Anthony R Von Fange III',
                [
                    'salutation' => 'Mr.',
                    'firstname' => 'Anthony',
                    'initials' => 'R',
                    'lastname' => 'von Fange',
                    'suffix' => 'III',
                ]
            ],
            [
                'J. B. Hunt',
                [
                    'firstname' => 'J.',
                    'initials' => 'B.',
                    'lastname' => 'Hunt',
                ]
            ],
            [
                'J.B. Hunt',
                [
                    'firstname' => 'J.B.',
                    'lastname' => 'Hunt',
                ]
            ],
            [
                'Edward Senior III',
                [
                    'firstname' => 'Edward',
                    'lastname' => 'Senior',
                    'suffix' => 'III'
                ]
            ],
            [
                'Edward Dale Senior II',
                [
                    'firstname' => 'Edward',
                    'lastname' => 'Dale',
                    'suffix' => 'Senior II'
                ]
            ],
            [
                'Dale Edward Jones Senior',
                [
                    'firstname' => 'Dale',
                    'middlename' => 'Edward',
                    'lastname' => 'Jones',
                    'suffix' => 'Senior'
                ]
            ],
            [
                'Jason Rodriguez Sr.',
                [
                    'firstname' => 'Jason',
                    'lastname' => 'Rodriguez',
                    'suffix' => 'Sr'
                ]
            ],
            [
                'Jason Senior',
                [
                    'firstname' => 'Jason',
                    'lastname' => 'Senior',
                ]
            ],
            [
                'Bill Junior',
                [
                    'firstname' => 'Bill',
                    'lastname' => 'Junior',
                ]
            ],
            [
                'Sara Ann Fraser',
                [
                    'firstname' => 'Sara',
                    'middlename' => 'Ann',
                    'lastname' => 'Fraser',
                ]
            ],
            [
                'Adam',
                [
                    'firstname' => 'Adam',
                ]
            ],
            [
                'OLD MACDONALD',
                [
                    'firstname' => 'Old',
                    'lastname' => 'Macdonald',
                ]
            ],
            [
                'Old MacDonald',
                [
                    'firstname' => 'Old',
                    'lastname' => 'MacDonald',
                ]
            ],
            [
                'Old McDonald',
                [
                    'firstname' => 'Old',
                    'lastname' => 'McDonald',
                ]
            ],
            [
                'Old Mc Donald',
                [
                    'firstname' => 'Old',
                    'middlename' => 'Mc',
                    'lastname' => 'Donald',
                ]
            ],
            [
                'Old Mac Donald',
                [
                    'firstname' => 'Old',
                    'middlename' => 'Mac',
                    'lastname' => 'Donald',
                ]
            ],
            [
                'James van Allen',
                [
                    'firstname' => 'James',
                    'lastname' => 'van Allen',
                ]
            ],
            [
                'Jimmy (Bubba) Smith',
                [
                    'firstname' => 'Jimmy',
                    'lastname' => 'Smith',
                    'nickname' => 'Bubba',
                ]
            ],
            [
                'Miss Jennifer Shrader Lawrence',
                [
                    'salutation' => 'Ms.',
                    'firstname' => 'Jennifer',
                    'middlename' => 'Shrader',
                    'lastname' => 'Lawrence',
                ]
            ],
            [
                'Dr. Jonathan Smith',
                [
                    'salutation' => 'Dr.',
                    'firstname' => 'Jonathan',
                    'lastname' => 'Smith',
                ]
            ],
            [
                'Miss Jamie P. Harrowitz',
                [
                    'salutation' => 'Ms.',
                    'firstname' => 'Jamie',
                    'initials' => 'P.',
                    'lastname' => 'Harrowitz',
                ]
            ],
            [
                'Mr John Doe',
                [
                    'salutation' => 'Mr.',
                    'firstname' => 'John',
                    'lastname' => 'Doe',
                ]
            ],
            [
                'Rev. Dr John Doe',
                [
                    'salutation' => 'Rev. Dr.',
                    'firstname' => 'John',
                    'lastname' => 'Doe',
                ]
            ],
            [
                'Anthony Von Fange III',
                [
                    'firstname' => 'Anthony',
                    'lastname' => 'von Fange',
                    'suffix' => 'III'
                ]
            ],
            [
                'Smarty Pants Phd',
                [
                    'firstname' => 'Smarty',
                    'lastname' => 'Pants',
                    'suffix' => 'PhD'
                ]
            ],
            [
                'Mark Peter Williams',
                [
                    'firstname' => 'Mark',
                    'middlename' => 'Peter',
                    'lastname' => 'Williams',
                ]
            ],
            [
                'Mark P Williams',
                [
                    'firstname' => 'Mark',
                    'lastname' => 'Williams',
                    'initials' => 'P',
                ]
            ],
            [
                'Mark P. Williams',
                [
                    'firstname' => 'Mark',
                    'initials' => 'P.',
                    'lastname' => 'Williams',
                ]
            ],
            [
                'M Peter Williams',
                [
                    'firstname' => 'Peter',
                    'initials' => 'M',
                    'lastname' => 'Williams',
                ]
            ],
            [
                'M. Peter Williams',
                [
                    'firstname' => 'Peter',
                    'initials' => 'M.',
                    'lastname' => 'Williams',
                ]
            ],
            [
                'M. P. Williams',
                [
                    'firstname' => 'M.',
                    'initials' => 'P.',
                    'lastname' => 'Williams',
                ]
            ],
            [
                'The Rev. Mark Williams',
                [
                    'salutation' => 'Rev.',
                    'firstname' => 'Mark',
                    'lastname' => 'Williams',
                ]
            ],
            [
                'Mister Mark Williams',
                [
                    'salutation' => 'Mr.',
                    'firstname' => 'Mark',
                    'lastname' => 'Williams',
                ]
            ],
            [
                'Fraser, Joshua',
                [
                    'firstname' => 'Joshua',
                    'lastname' => 'Fraser',
                ]
            ],
            [
                'Mrs. Brown, Amanda',
                [
                    'salutation' => 'Mrs.',
                    'firstname' => 'Amanda',
                    'lastname' => 'Brown',
                ]
            ],
            [
                "Mr.\r\nPaul\rJoseph\nMaria\tWinters",
                [
                    'salutation' => 'Mr.',
                    'firstname' => 'Paul',
                    'middlename' => 'Joseph Maria',
                    'lastname' => 'Winters',
                ]
            ],
            [
                'Van Truong',
                [
                    'firstname' => 'Van',
                    'lastname' => 'Truong',
                ],
            ],
            [
                'John Van',
                [
                    'firstname' => 'John',
                    'lastname' => 'Van',
                ],
            ],
            [
                'Mr. Van Truong',
                [
                    'salutation' => 'Mr.',
                    'firstname' => 'Van',
                    'lastname' => 'Truong',
                ],
            ],
            [
                'Anthony Von Fange III, PHD',
                [
                    'firstname' => 'Anthony',
                    'lastname' => 'von Fange',
                    'suffix' => 'III PhD'
                ]
            ],
            [
                'Jimmy (Bubba Junior) Smith',
                [
                    'nickname' => 'Bubba Junior',
                    'firstname' => 'Jimmy',
                    'lastname' => 'Smith',
                ]
            ],
            [
                'Jonathan Smith, MD',
                [
                    'firstname' => 'Jonathan',
                    'lastname' => 'Smith',
                    'suffix' => 'MD'
                ]
            ],
            [
                'Kirk, James T.',
                [
                    'firstname' => 'James',
                    'initials' => 'T.',
                    'lastname' => 'Kirk',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function dysfunctionalFirstnameProvider()
    {
        return [
            // fails. both initials should be capitalized
            [
                'JB Hunt',
                [
                    'firstname' => 'JB',
                    'lastname' => 'Hunt',
                ]
            ],
        ];
    }

    /**
     * @dataProvider provider
     *
     * @param $input
     * @param $expectation
     */
    public function testParse($input, $expectation)
    {
        $parser = new Parser();
        $name = $parser->parse($input);

        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals($expectation, $name->getAll());
    }

    public function testSetGetWhitespace()
    {
        $parser = new Parser();
        $parser->setWhitespace('abc');
        $this->assertSame('abc', $parser->getWhitespace());
        $parser->setWhitespace(' ');
        $this->assertSame(' ', $parser->getWhitespace());
        $parser->setWhitespace('   _');
        $this->assertSame('   _', $parser->getWhitespace());
    }
}
