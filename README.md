# THE ICONIC Name Parser

[![Build Status](https://travis-ci.org/theiconic/name-parser.svg?branch=master&t=201705161308)](https://travis-ci.org/theiconic/name-parser)
[![Coverage Status](https://coveralls.io/repos/github/theiconic/name-parser/badge.svg?branch=master&t=201705161308)](https://coveralls.io/github/theiconic/name-parser?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/theiconic/name-parser/badges/quality-score.png?b=master&t=201705161308)](https://scrutinizer-ci.com/g/theiconic/name-parser/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/theiconic/name-parser/v/stable?t=201705161308)](https://packagist.org/packages/theiconic/name-parser)
[![Total Downloads](https://poser.pugx.org/theiconic/name-parser/downloads?t=201705161308)](https://packagist.org/packages/theiconic/name-parser)
[![License](https://poser.pugx.org/theiconic/name-parser/license?t=201705161308)](https://packagist.org/packages/theiconic/name-parser)

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

This package has been used by The Iconic in production for years,
successfully processing hundreds of thousands of customer names.

## Features

### Supported patterns
This parser is able to handle name patterns with and without comma:
```
... [firstname] ... [lastname] ...
```
```
... [lastname] ..., ... [firstname] ...
```
```
... [lastname] ..., ... [firstname] ..., [suffix]
```

### Supported parts
- salutations (e.g. Mr, Mrs, Dr, etc.)
- first name
- middle names
- initials (single letters, possibly followed by a dot)
- nicknames (parts within parenthesis, brackets etc.)
- last names (also supports prefixes like von, de etc.)
- suffixes (Jr, Senior, 3rd, PhD, etc.)

### Other features
- multi-language support for salutations, suffixes and lastname prefixes
- customizable nickname delimiters
- customizable normalisation of all output strings
  (original values remain accessible)
- customizable whitespace

## Examples

More than 60 different successfully parsed name patterns can be found in the
[parser unit test](https://github.com/theiconic/name-parser/blob/master/tests/ParserTest.php#L12-L12).

## Setup
```$xslt
composer require theiconic/name-parser
```

## Usage

### Basic usage
```php
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

print_r($name->getAll());

echo $name;
```
An empty string is returned for missing parts.

### Special part retrieval features
#### Explicit last name parts
You can retrieve last name prefixes and pure last names separately with
```php
echo $name->getLastnamePrefix();
echo $name->getLastname(true); // true enables strict mode for pure lastnames, only
```

#### Nick names with normalized wrapping
By default, `getNickname()` returns the pure string of nick names. However, you can
pass `true` to have the same normalised parenthesis wrapping applied as in `echo $name`:
```php
echo $name->getNickname(); // The Giant
echo $name->getNickname(true); // (The Giant)
```

#### Re-print given name in the order as entered
You can re-print the parts that form a given name (that is first name, middle names and any initials)
in the order they were entered in while still applying normalisation
via `getGivenName()`:
```php
echo $name->getGivenName(); // J. Peter M.
```

#### Re-print full name (actual name parts only)
You can re-print the full name, that is the given name as above followed by
any last name parts (excluding any salutations, nick names or suffixes)
via `getFullName()`:
```php
echo $name->getFullName(); // J. Peter M. Schluter
```

### Setting Languages
```php
$parser = new TheIconic\NameParser\Parser([
    new TheIconic\NameParser\Language\English(), //default
    new TheIconic\NameParser\Language\German(),
])
```

### Setting nickname delimiters
```php
$parser = new TheIconic\NameParser\Parser();
$parser->setNicknameDelimiters(['(' => ')']);
```

### Setting whitespace characters
```php
$parser = new TheIconic\NameParser\Parser();
$parser->setWhitespace("\t _.");
```

### Limiting the position of salutations
```php
$parser = new TheIconic\NameParser\Parser();
$parser->setMaxSalutationIndex(2);
```
This will require salutations to appear within the
first two words of the given input string.
This defaults to half the amount of words in the input string,
meaning that effectively the salutation may occur within
the first half of the name parts.

### Adjusting combined initials support
```php
$parser = new TheIconic\NameParser\Parser();
$parser->setMaxCombinedInitials(3);
```
Combined initials are combinations of several
uppercased letters, e.g. `DJ` or `J.T.` without
separating spaces. The parser will treat such sequences
of uppercase letters (with optional dots) as combined
initials and parse them into individual initials.
This value adjusts the maximum number of uppercase letters
in a single name part are recognised as comnined initials.
Parts with more than the specified maximum amount of letters
will not be parsed into initials and hence will most likely
be parsed into first or middle names.

The default value is 2.

To disable combined initials support, set this value to 1;

## Tips
### Provide clean input strings
If your input string consists of more than just the name and
directly related bits like salutations, suffixes etc.,
any additional parts can easily confuse the parser.
It is therefore recommended to pre-process any non-clean input
to isolate the name before passing it to the parser.

### Multi-pass parsing
We have not played with this, but you may be able to improve results
by chaining several parses in sequence. E.g.
```php
$parser = new Parser();
$name = $parser->parse($input);
$name = $parser->parse((string) $name);
...
```
You can even compose your new input string from individual parts of
a previous pass.

### Dealing with names in different languages
The parser is primarily built around the patterns of english names
but tries to be compatible with names in other languages. Problems
occur with different salutations, last name prefixes, suffixes etc.
or in some cases even with the parsing order.

To solve problems with salutations, last name prefixes and suffixes
you can create a separate language definition file and inject it when
instantiating the parser, see 'Setting Languages' above and compare
the existing language files as examples.

To deal with parsing order you may want to reformat the input string,
e.g. by simply splitting it into words and reversing their order.
You can even let the parser run over the original string and then over
the reversed string and then pick the best results from either of the
two resulting name objects. E.g. the salutation from the one and the
lastname from the other.

The name parser has no in-built language detection. However, you may
already ask the user for their nationality in the same form. If you
do that you may want to narrow the language definition files passed
into the parser to the given language and maybe a fallback like english.
You can also use this information to prepare the input string as outlined
above.

Alternatively, Patrick Schur as a [PHP language detection library](https://github.com/patrickschur/language-detection)
that seems to deliver astonishing results. It won't give you much luck if
you run it over the the name input string only, but if you have any more
text from the person in their actual language, you could use this to detect
the language and then proceed as above.

### Gender detection
Gender detection is outside the scope of this project.
Detecting the gender from a name often requires large lists of first
name to gender mappings.

However, you can use this parser to extract salutation, first name and
nick names from the input string and then use these to implement gender
detection using another package (e.g. [this one](https://github.com/tuqqu/gender-detector)) or service.

### Having fun with normalisation
Writing different language files can not only be useful for parsing,
but you can remap the normalised versions of salutations, prefixes and suffixes
to transform them into something totally different.

E.g. you could map `Ms.` to `princess of the kingdom of` and then output
the parts in appropriate order to build a pipeline that automatically transforms
e.g. `Ms. Louisa Lichtenstein` into `Louisa, princess of the kingdom of Lichtenstein`.
Of course, this is a silly and rather contrived example, but you get the
gist.

Of course this can also be used in more useful ways, e.g. to spell out
abbreviated titles, like `Prof.` as `Professor` etc. .

## License

THE ICONIC Name Parser library for PHP is released under the MIT License.
