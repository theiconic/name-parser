<?php

namespace TheIconic\NameParser;

use PHPUnit_Framework_TestCase;

class ParserTest extends PHPUnit_Framework_TestCase
{

    public function provider()
    {
        return array(
            array(
                'Hans Christian Anderssen',
                array(
                    'firstname' => 'Hans Christian',
                    'lastname' => 'Anderssen',
                    'salutation' => '',
                    'initials' => '',
                    'suffix' => '',
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
                "Mr Anthony R Von Fange III",
                array(
                    "salutation" => "Mr.",
                    "firstname"      => "Anthony",
                    "initials"   => "R",
                    "lastname"      => "von Fange",
                    "suffix"     => "III"
                )
            ),
            array(
                "J. B. Hunt",
                array(
                    "salutation" => "",
                    "firstname"      => "J.",
                    "initials"   => "B.",
                    "lastname"      => "Hunt",
                    "suffix"     => ""
                )
            ),
            array(
                "J.B. Hunt",
                array(
                    "salutation" => "",
                    "firstname"      => "J.B.",
                    "initials"   => "",
                    "lastname"      => "Hunt",
                    "suffix"     => ""
                )
            ),
            array(
                "Edward Senior III",
                array(
                    "salutation" => "",
                    "firstname"      => "Edward",
                    "initials"   => "",
                    "lastname"      => "Senior",
                    "suffix"     => "III"
                )
            ),
            array(
                "Edward Dale Senior II",
                array(
                    "salutation" => "",
                    "firstname"      => "Edward Dale",
                    "initials"   => "",
                    "lastname"      => "Senior",
                    "suffix"     => "II"
                )
            ),
            array(
                "Dale Edward Jones Senior",
                array(
                    "salutation" => "",
                    "firstname"      => "Dale Edward",
                    "initials"   => "",
                    "lastname"      => "Jones",
                    "suffix"     => "Senior"
                )
            ),
            array(
                "Edward Senior II",
                array(
                    "salutation" => "",
                    "firstname"      => "Edward",
                    "initials"   => "",
                    "lastname"      => "Senior",
                    "suffix"     => "II"
                )
            ),
            array(
                "Dale Edward Senior II, PhD",
                array(
                    "salutation" => "",
                    "firstname"      => "Dale Edward",
                    "initials"   => "",
                    "lastname"      => "Senior",
                    "suffix"     => "II, PhD"
                )
            ),
            array(
                "Jason Rodriguez Sr.",
                array(
                    "salutation" => "",
                    "firstname"      => "Jason",
                    "initials"   => "",
                    "lastname"      => "Rodriguez",
                    "suffix"     => "Sr"
                )
            ),
            array(
                "Jason Senior",
                array(
                    "salutation" => "",
                    "firstname"      => "Jason",
                    "initials"   => "",
                    "lastname"      => "Senior",
                    "suffix"     => ""
                )
            ),
            array(
                "Bill Junior",
                array(
                    "salutation" => "",
                    "firstname"      => "Bill",
                    "initials"   => "",
                    "lastname"      => "Junior",
                    "suffix"     => ""
                )
            ),
            array(
                "Sara Ann Fraser",
                array(
                    "salutation" => "",
                    "firstname"      => "Sara Ann",
                    "initials"   => "",
                    "lastname"      => "Fraser",
                    "suffix"     => ""
                )
            ),
            array(
                "Adam",
                array(
                    "salutation" => "",
                    "firstname"      => "Adam",
                    "initials"   => "",
                    "lastname"      => "",
                    "suffix"     => ""
                )
            ),
            array(
                "OLD MACDONALD",
                array(
                    "salutation" => "",
                    "firstname"      => "Old",
                    "initials"   => "",
                    "lastname"      => "Macdonald",
                    "suffix"     => ""
                )
            ),
            array(
                "Old MacDonald",
                array(
                    "salutation" => "",
                    "firstname"      => "Old",
                    "initials"   => "",
                    "lastname"      => "MacDonald",
                    "suffix"     => ""
                )
            ),
            array(
                "Old McDonald",
                array(
                    "salutation" => "",
                    "firstname"      => "Old",
                    "initials"   => "",
                    "lastname"      => "McDonald",
                    "suffix"     => ""
                )
            ),
            array(
                "Old Mc Donald",
                array(
                    "salutation" => "",
                    "firstname"      => "Old Mc",
                    "initials"   => "",
                    "lastname"      => "Donald",
                    "suffix"     => ""
                )
            ),
            array(
                "Old Mac Donald",
                array(
                    "salutation" => "",
                    "firstname"      => "Old Mac",
                    "initials"   => "",
                    "lastname"      => "Donald",
                    "suffix"     => ""
                )
            ),
            array(
                "James van Allen",
                array(
                    "salutation" => "",
                    "firstname"      => "James",
                    "initials"   => "",
                    "lastname"      => "van Allen",
                    "suffix"     => ""
                )
            ),
            array(
                "Jimmy (Bubba) Smith",
                array(
                    "nickname"   => "Bubba",
                    "salutation" => "",
                    "firstname"      => "Jimmy",
                    "initials"   => "",
                    "lastname"      => "Smith",
                    "suffix"     => ""
                )
            ),
            array(
                "Miss Jennifer Shrader Lawrence",
                array(
                    "salutation" => "Ms.",
                    "firstname"      => "Jennifer Shrader",
                    "initials"   => "",
                    "lastname"      => "Lawrence",
                    "suffix"     => ""
                )
            ),
            array(
                "Jonathan Smith, MD",
                array(
                    "salutation" => "",
                    "firstname"      => "Jonathan",
                    "initials"   => "",
                    "lastname"      => "Smith",
                    "suffix"     => "MD"
                )
            ),
            array(
                "Dr. Jonathan Smith",
                array(
                    "salutation" => "Dr.",
                    "firstname"      => "Jonathan",
                    "initials"   => "",
                    "lastname"      => "Smith",
                    "suffix"     => ""
                )
            ),
            array(
                "Jonathan Smith IV, PhD",
                array(
                    "salutation" => "",
                    "firstname"      => "Jonathan",
                    "initials"   => "",
                    "lastname"      => "Smith",
                    "suffix"     => "IV, PhD"
                )
            ),
            array(
                "Miss Jamie P. Harrowitz",
                array(
                    "salutation" => "Ms.",
                    "firstname"      => "Jamie",
                    "initials"   => "P.",
                    "lastname"      => "Harrowitz",
                    "suffix"     => ""
                )
            ),
            array(
                "Mr John Doe",
                array(
                    "salutation" => "Mr.",
                    "firstname"      => "John",
                    "initials"   => "",
                    "lastname"      => "Doe",
                    "suffix"     => ""
                )
            ),
            array(
                "Rev. Dr John Doe",
                array(
                    "salutation" => "Rev. Dr.",
                    "firstname"      => "John",
                    "initials"   => "",
                    "lastname"      => "Doe",
                    "suffix"     => ""
                )
            ),
            array(
                "Anthony Von Fange III",
                array(
                    "salutation" => "",
                    "firstname"      => "Anthony",
                    "initials"   => "",
                    "lastname"      => "von Fange",
                    "suffix"     => "III"
                )
            ),
            array(
                "Anthony Von Fange III, PhD",
                array(
                    "salutation" => "",
                    "firstname"      => "Anthony",
                    "initials"   => "",
                    "lastname"      => "von Fange",
                    "suffix"     => "III, PhD"
                )
            ),
            array(
                "Smarty Pants Phd",
                array(
                    "salutation" => "",
                    "firstname"      => "Smarty",
                    "initials"   => "",
                    "lastname"      => "Pants",
                    "suffix"     => "PhD"
                )
            ),
            array(
                "Mark Peter Williams",
                array(
                    "salutation" => "",
                    "firstname"      => "Mark Peter",
                    "initials"   => "",
                    "lastname"      => "Williams",
                    "suffix"     => ""
                )
            ),
            array(
                "Mark P Williams",
                array(
                    "salutation" => "",
                    "firstname"      => "Mark",
                    "initials"   => "P",
                    "lastname"      => "Williams",
                    "suffix"     => ""
                )
            ),
            array(
                "Mark P. Williams",
                array(
                    "salutation" => "",
                    "firstname"      => "Mark",
                    "initials"   => "P.",
                    "lastname"      => "Williams",
                    "suffix"     => ""
                )
            ),
            array(
                "M Peter Williams",
                array(
                    "salutation" => "",
                    "firstname"      => "Peter",
                    "initials"   => "M",
                    "lastname"      => "Williams",
                    "suffix"     => ""
                )
            ),
            array(
                "M. Peter Williams",
                array(
                    "salutation" => "",
                    "firstname"      => "Peter",
                    "initials"   => "M.",
                    "lastname"      => "Williams",
                    "suffix"     => ""
                )
            ),
            array(
                "M. P. Williams",
                array(
                    "salutation" => "",
                    "firstname"      => "M.",
                    "initials"   => "P.",
                    "lastname"      => "Williams",
                    "suffix"     => ""
                )
            ),
            array(
                "The Rev. Mark Williams",
                array(
                    "salutation" => "Rev.",
                    "firstname"      => "Mark",
                    "initials"   => "",
                    "lastname"      => "Williams",
                    "suffix"     => ""
                )
            ),
            array(
                "Mister Mark Williams",
                array(
                    "salutation" => "Mr.",
                    "firstname"      => "Mark",
                    "initials"   => "",
                    "lastname"      => "Williams",
                    "suffix"     => ""
                )
            )
        );
    }
    
    public function disfunctionalastnameProvider()
    {
        return array(
            // fails. format not yet supported
            array(
                "Fraser, Joshua",
                array(
                    "salutation" => "",
                    "firstname"      => "Joshua",
                    "initials"   => "",
                    "lastname"      => "Fraser",
                    "suffix"     => ""
                )
            ),
            // fails. both initials should be capitalized
            array(
                "JB Hunt",
                array(
                    "salutation" => "",
                    "firstname"      => "JB",
                    "initials"   => "",
                    "lastname"      => "Hunt",
                    "suffix"     => ""
                )
            ),
            // fails.  doesn't handle multiple words inside parenthesis
            array(
                "Jimmy (Bubba Junior) Smith",
                array(
                    "nickname"   => "Bubba Junior",
                    "salutation" => "",
                    "firstname"      => "Jimmy",
                    "initials"   => "",
                    "lastname"      => "Smith",
                    "suffix"     => ""
                )
            ),
            // fails.  should normalize the PhD suffix
            array(
                "Anthony Von Fange III, PHD",
                array(
                    "salutation" => "",
                    "firstname"      => "Anthony",
                    "initials"   => "",
                    "lastname"      => "Von Fange",
                    "suffix"     => "III, PhD"
                )
            ),
            // fails.  should treat "Silly" as the nickname or remove altogether
            array(
                "Not So Smarty Pants, Silly",
                array(
                    "nickname"   => "Silly",
                    "salutation" => "",
                    "firstname"      => "Not So Smarty",
                    "initials"   => "",
                    "lastname"      => "Pants",
                    "suffix"     => ""
                )
            )
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
        $parser->init();
        $name = $parser->parse($input);

        $this->assertInstanceOf('\\TheIconic\\NameParser\\Name', $name);
        $results = [
            'salutation' => $name->getSalutation(),
            'firstname' => $name->getFirstname(),
            'lastname' => $name->getLastname(),
            'initials' => $name->getInitials(),
            'suffix' => $name->getSuffix(),
        ];
        $this->assertEquals($expectation, $results);
    }

}
