<?php

namespace TheIconic\NameParser\Part;

use PHPUnit\Framework\TestCase;

class NormalisationTest extends TestCase
{
    public function testCamelcasing()
    {
        $part = new Lastname('McDonald');
        $this->assertEquals('McDonald', $part->normalize());

        $part = new Lastname('ubel');
        $this->assertEquals('Ubel', $part->normalize());

        $part = new Lastname('übel');
        $this->assertEquals('Übel', $part->normalize());

        $part = new Firstname('Anne-Marie');
        $this->assertEquals('Anne-Marie', $part->normalize());

        $part = new Firstname('etna');
        $this->assertEquals('Etna', $part->normalize());

        $part = new Firstname('thái');
        $this->assertEquals('Thái', $part->normalize());

        $part = new Lastname('nguyễn');
        $this->assertEquals('Nguyễn', $part->normalize());
    }
}
