# THE ICONIC Name Parser

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-8892BF.svg)](https://www.php.net/supported-versions.php)
[![PHPUnit](https://img.shields.io/badge/tested%20with-PHPUnit%2012-3C9CD7.svg)](https://phpunit.de)
[![Latest Tag](https://img.shields.io/github/v/tag/kwojtas6/name-parser?sort=semver)](https://github.com/kwojtas6/name-parser/tags)
[![License](https://img.shields.io/github/license/kwojtas6/name-parser.svg)](https://github.com/kwojtas6/name-parser/blob/main/LICENSE)
[![Forked from](https://img.shields.io/badge/forked%20from-theiconic%2Fname--parser-lightgrey.svg)](https://github.com/theiconic/name-parser)

> **This repository is a fork** of [theiconic/name-parser](https://github.com/theiconic/name-parser),
> based on upstream release `v1.2.9`.
> The fork is published as `kwojtas/name-parser` and modernises the library for PHP 8.2+.

## Changes compared to the original project

### Requirements and tooling
- requires **PHP >= 8.2** (upstream: PHP >= 7.1) and the **`mbstring`** extension
- test suite migrated from PHPUnit 7 to **PHPUnit 12**:
  - data providers are `public static` and use the `#[DataProvider]` attribute instead of `@dataProvider` annotations
  - `getMockForAbstractClass()` replaced with anonymous classes
  - the abstract mapper test base class renamed to `AbstractMapperTestCase`
  - `phpunit.xml.dist` rewritten for the current configuration schema; the suite fails on deprecations and warnings
- removed the dev dependencies `php-mock/php-mock-phpunit` and `php-coveralls/php-coveralls`, together with `tests/bootstrap.php`
- package renamed to `kwojtas/name-parser`; **the PHP namespace `TheIconic\NameParser` is unchanged**, so existing code keeps working

### Code modernisation (PHP 8.x features)
- `declare(strict_types=1)` in all source files
- typed properties and full parameter/return type declarations, including union types (`string|AbstractPart`, `int|false`)
- constructor property promotion with `readonly` properties in all mappers and pre-normalised parts
- explicitly nullable parameters (`?array`, `?string`) – fixes the PHP 8.4 implicit-nullable deprecations
- first-class callable syntax (`$this->camelcaseReplace(...)`) instead of `[$this, 'method']` callables
- `str_ends_with()`, `intdiv()`, `$object::class` and class-name based part lookups in `Name`
- fluent setters return `static`

### Bug fixes
- parsing names like `His (Jim) Smith` no longer throws a `TypeError`
  (the multi-word salutation check received an already mapped nickname part)
- the salutation mapper no longer reads past the end of the name when `setMaxSalutationIndex()` exceeds the number of words
- custom whitespace characters containing `/` are now escaped correctly
- camel-casing always uses `mb_convert_case()`; the non-multibyte fallback was removed

### New languages
- `TheIconic\NameParser\Language\Dutch` – salutations (Dhr., De heer, Mevr., Mw., Ir., Drs., …),
  "tussenvoegsels" as last name prefixes (van, de, den, der, ter, ten, uit, v.d., …) and suffixes (jr., sr., MSc, …)
- `TheIconic\NameParser\Language\Spanish` – salutations (Sr., Sra., Srta., Don, Doña, Dra., Lic., …),
  last name prefixes (de, del, la, las, los) and suffixes (Jr., hijo, …)

### Backwards compatibility
Code that only *uses* the parser works as before (except that `Parser::parse()` now requires a string).
Code that *extends* the library classes may need adjustments:
- overriding methods must declare compatible return types (e.g. `map(array $parts): array`)
- overridden fluent setters must return `static`
- mapper configuration properties are `readonly`

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
```bash
composer require kwojtas/name-parser
```

If the package is not available on Packagist, add this repository as a VCS source first:
```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/kwojtas6/name-parser" }
]
```

The original package is still available via `composer require theiconic/name-parser`.

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
    new TheIconic\NameParser\Language\Dutch(),
    new TheIconic\NameParser\Language\Spanish(),
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
