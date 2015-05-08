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
