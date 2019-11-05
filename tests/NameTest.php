<?php

namespace TheIconic\NameParser;

use PHPUnit\Framework\TestCase;
use TheIconic\NameParser\Part\Firstname;
use TheIconic\NameParser\Part\Initial;
use TheIconic\NameParser\Part\Lastname;
use TheIconic\NameParser\Part\LastnamePrefix;
use TheIconic\NameParser\Part\Middlename;
use TheIconic\NameParser\Part\Nickname;
use TheIconic\NameParser\Part\Salutation;
use TheIconic\NameParser\Part\Suffix;

class NameTest extends TestCase
{
    public function testToString()
    {
        $parts = [
            new Salutation('Mr', 'Mr.'),
            new Firstname('James'),
            new Middlename('Morgan'),
            new Nickname('Jim'),
            new Initial('T.'),
            new Lastname('Smith'),
            new Suffix('I', 'I'),
        ];

        $name = new Name($parts);

        $this->assertSame($parts, $name->getParts());
        $this->assertSame('Mr. James (Jim) Morgan T. Smith I', (string) $name);
    }

    public function testGetNickname()
    {
        $name = new Name([
            new Nickname('Jim'),
        ]);

        $this->assertSame('Jim', $name->getNickname());
        $this->assertSame('(Jim)', $name->getNickname(true));
    }

    public function testGettingLastnameAndLastnamePrefixSeparately()
    {
        $name = new Name([
            new Firstname('Frank'),
            new LastnamePrefix('van'),
            new Lastname('Delft'),
        ]);

        $this->assertSame('Frank', $name->getFirstname());
        $this->assertSame('van', $name->getLastnamePrefix());
        $this->assertSame('Delft', $name->getLastname(true));
        $this->assertSame('van Delft', $name->getLastname());
    }

    public function testGetGivenNameShouldReturnGivenNameInGivenOrder(): void
    {
        $parser = new Parser();
        $name = $parser->parse('Schuler, J. Peter M.');
        $this->assertSame('J. Peter M.', $name->getGivenName());
    }

    public function testGetFullNameShouldReturnTheFullNameInGivenOrder(): void
    {
        $parser = new Parser();
        $name = $parser->parse('Schuler, J. Peter M.');
        $this->assertSame('J. Peter M. Schuler', $name->getFullName());
    }
}
