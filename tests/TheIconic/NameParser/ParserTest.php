<?php

namespace TheIconic\NameParser;

use PHPUnit_Framework_TestCase;

class ParserTest extends PHPUnit_Framework_TestCase
{

    public function provider()
    {
        return array(
            array(
                'James Norrington',
                array(
                    'firstname' => 'James',
                    'lastname' => 'Norrington',
                )

            ),
            array(
                'Hans Christian Anderssen',
                array(
                    'firstname' => 'Hans',
                    'lastname' => 'Anderssen',
                    'middlename' => 'Christian',
                )
            ),
            array(
                'Mr Anthony R Von Fange III',
                array(
                    'salutation' => 'Mr.',
                    'firstname' => 'Anthony',
                    'initials' => 'R',
                    'lastname' => 'von Fange',
                    'suffix' => 'III',
                )
            ),
            array(
                'Mr Anthony R Von Fange III',
                array(
                    'salutation' => 'Mr.',
                    'firstname'      => 'Anthony',
                    'initials'   => 'R',
                    'lastname'      => 'von Fange',
                    'suffix'     => 'III'
                )
            ),
            array(
                'J. B. Hunt',
                array(
                    'firstname'      => 'J.',
                    'initials'   => 'B.',
                    'lastname'      => 'Hunt',
                )
            ),
            array(
                'J.B. Hunt',
                array(
                    'firstname'      => 'J.B.',
                    'lastname'      => 'Hunt',
                )
            ),
            array(
                'Edward Senior III',
                array(
                    'firstname'      => 'Edward',
                    'lastname'      => 'Senior',
                    'suffix'     => 'III'
                )
            ),
            array(
                'Edward Dale Senior II',
                array(
                    'firstname'      => 'Edward',
                    'lastname'      => 'Dale',
                    'suffix'     => 'Senior II'
                )
            ),
            array(
                'Dale Edward Jones Senior',
                array(
                    'firstname' => 'Dale',
                    'middlename' => 'Edward',
                    'lastname' => 'Jones',
                    'suffix' => 'Senior'
                )
            ),
            array(
                'Jason Rodriguez Sr.',
                array(
                    'firstname'      => 'Jason',
                    'lastname'      => 'Rodriguez',
                    'suffix'     => 'Sr'
                )
            ),
            array(
                'Jason Senior',
                array(
                    'firstname'      => 'Jason',
                    'lastname'      => 'Senior',
                )
            ),
            array(
                'Bill Junior',
                array(
                    'firstname' => 'Bill',
                    'lastname' => 'Junior',
                )
            ),
            array(
                'Sara Ann Fraser',
                array(
                    'firstname' => 'Sara',
                    'middlename' => 'Ann',
                    'lastname' => 'Fraser',
                )
            ),
            array(
                'Adam',
                array(
                    'firstname' => 'Adam',
                )
            ),
            array(
                'OLD MACDONALD',
                array(
                    'firstname'      => 'Old',
                    'lastname'      => 'Macdonald',
                )
            ),
            array(
                'Old MacDonald',
                array(
                    'firstname'      => 'Old',
                    'lastname'      => 'MacDonald',
                )
            ),
            array(
                'Old McDonald',
                array(
                    'firstname'      => 'Old',
                    'lastname'      => 'McDonald',
                )
            ),
            array(
                'Old Mc Donald',
                array(
                    'firstname'      => 'Old',
                    'middlename' => 'Mc',
                    'lastname'      => 'Donald',
                )
            ),
            array(
                'Old Mac Donald',
                array(
                    'firstname'      => 'Old',
                    'middlename' => 'Mac',
                    'lastname'      => 'Donald',
                )
            ),
            array(
                'James van Allen',
                array(
                    'firstname'      => 'James',
                    'lastname'      => 'van Allen',
                )
            ),
            array(
                'Jimmy (Bubba) Smith',
                array(
                    'firstname' => 'Jimmy',
                    'lastname' => 'Smith',
                    'nickname' => 'Bubba',
                )
            ),
            array(
                'Miss Jennifer Shrader Lawrence',
                array(
                    'salutation' => 'Ms.',
                    'firstname' => 'Jennifer',
                    'middlename' => 'Shrader',
                    'lastname' => 'Lawrence',
                )
            ),
            array(
                'Dr. Jonathan Smith',
                array(
                    'salutation' => 'Dr.',
                    'firstname'      => 'Jonathan',
                    'lastname'      => 'Smith',
                )
            ),
            array(
                'Miss Jamie P. Harrowitz',
                array(
                    'salutation' => 'Ms.',
                    'firstname'      => 'Jamie',
                    'initials'   => 'P.',
                    'lastname'      => 'Harrowitz',
                )
            ),
            array(
                'Mr John Doe',
                array(
                    'salutation' => 'Mr.',
                    'firstname'      => 'John',
                    'lastname'      => 'Doe',
                )
            ),
            array(
                'Rev. Dr John Doe',
                array(
                    'salutation' => 'Rev. Dr.',
                    'firstname'      => 'John',
                    'lastname'      => 'Doe',
                )
            ),
            array(
                'Anthony Von Fange III',
                array(
                    'firstname'      => 'Anthony',
                    'lastname'      => 'von Fange',
                    'suffix'     => 'III'
                )
            ),
            array(
                'Smarty Pants Phd',
                array(
                    'firstname'      => 'Smarty',
                    'lastname'      => 'Pants',
                    'suffix'     => 'PhD'
                )
            ),
            array(
                'Mark Peter Williams',
                array(
                    'firstname' => 'Mark',
                    'middlename' => 'Peter',
                    'lastname' => 'Williams',
                )
            ),
            array(
                'Mark P Williams',
                array(
                    'firstname'      => 'Mark',
                    'lastname'      => 'Williams',
                    'initials' => 'P',
                )
            ),
            array(
                'Mark P. Williams',
                array(
                    'firstname'      => 'Mark',
                    'initials'   => 'P.',
                    'lastname'      => 'Williams',
                )
            ),
            array(
                'M Peter Williams',
                array(
                    'firstname'      => 'Peter',
                    'initials'   => 'M',
                    'lastname'      => 'Williams',
                )
            ),
            array(
                'M. Peter Williams',
                array(
                    'firstname'      => 'Peter',
                    'initials'   => 'M.',
                    'lastname'      => 'Williams',
                )
            ),
            array(
                'M. P. Williams',
                array(
                    'firstname'      => 'M.',
                    'initials'   => 'P.',
                    'lastname'      => 'Williams',
                )
            ),
            array(
                'The Rev. Mark Williams',
                array(
                    'salutation' => 'Rev.',
                    'firstname'      => 'Mark',
                    'lastname'      => 'Williams',
                )
            ),
            array(
                'Mister Mark Williams',
                array(
                    'salutation' => 'Mr.',
                    'firstname'      => 'Mark',
                    'lastname'      => 'Williams',
                )
            ),
            array(
                'Fraser, Joshua',
                array(
                    'firstname'      => 'Joshua',
                    'lastname'      => 'Fraser',
                )
            ),
            array(
                'Mrs. Brown, Amanda',
                array(
                    'salutation' => 'Mrs.',
                    'firstname' => 'Amanda',
                    'lastname' => 'Brown',
                )
            ),
            array(
                "Mr.\r\nPaul\rJoseph\nMaria\tWinters",
                array(
                    'salutation' => 'Mr.',
                    'firstname' => 'Paul',
                    'middlename' => 'Joseph Maria',
                    'lastname' => 'Winters',
                )
            ),
            array(
                'Van Truong',
                array(
                    'firstname' => 'Van',
                    'lastname' => 'Truong',
                ),
            ),
        );
    }
    
    public function disfunctionalastnameProvider()
    {
        return array(
            array(
                'Jonathan Smith, MD',
                array(
                    'firstname'      => 'Jonathan',
                    'lastname'      => 'Smith',
                    'suffix'     => 'MD'
                )
            ),
            // fails. both initials should be capitalized
            array(
                'JB Hunt',
                array(
                    'firstname'      => 'JB',
                    'lastname'      => 'Hunt',
                )
            ),
            // fails.  doesn't handle multiple words inside parenthesis
            array(
                'Jimmy (Bubba Junior) Smith',
                array(
                    'nickname'   => 'Bubba Junior',
                    'firstname'      => 'Jimmy',
                    'lastname'      => 'Smith',
                )
            ),
            // fails.  should normalize the PhD suffix
            array(
                'Anthony Von Fange III, PHD',
                array(
                    'firstname'      => 'Anthony',
                    'lastname'      => 'Von Fange',
                    'suffix'     => 'III, PhD'
                )
            ),
            // fails.  should treat 'Silly' as the nickname or remove altogether
            array(
                'Not So Smarty Pants, Silly',
                array(
                    'nickname'   => 'Silly',
                    'firstname'      => 'Not So Smarty',
                    'lastname'      => 'Pants',
                )
            ),
        );
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

        $this->assertInstanceOf('\\TheIconic\\NameParser\\Name', $name);
        $this->assertEquals($expectation, $name->getAll());
    }

}
