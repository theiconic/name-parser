# THE ICONIC Name Parser

## Purpose
This is a universal, language-independent name parser.

Its purpose is to split a single string containing a full name,
possibly including salutation, initials, suffixes etc., into
meaningful parts like firstname, lastname, initials, and so on.

It is mostly tailored towards english names but works pretty well
with non-english names as long as they use latin spelling.

E.g. **Mr Anthony R Von Fange III** is parsed to
- salutation: **Mr.**
- firstname: **Anthony**
- initials: **R**
- lastname: **von Fange**
- suffix: **III**

## Setup
```$xslt
composer require theiconic/name-parser
```

## Usage

```
<?php

$parser = new TheIconic\NameParser\Parser();

$name = $parser->parse($input);

echo $name->getSalutation();
echo $name->getFirstname();
echo $name->getLastname();
echo $name->getMiddlename();
echo $name->getNickname();
echo $name->getInitials();
echo $name->getSuffix();
```
An empty string is returned for missing parts.

## Examples

An wide array of successfully parsed names can be found in the
[parser unit test](https://github.com/theiconic/name-parser/blob/master/tests/ParserTest.php#L12-L12).

## License

THE ICONIC Name Parser library for PHP is released under the MIT License.