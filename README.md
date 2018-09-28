# Matcha

Unit test library that taste good.

![PHP from Packagist](https://img.shields.io/packagist/php-v/khalyomede/matcha.svg)
![Packagist](https://img.shields.io/packagist/v/khalyomede/matcha.svg)
![Codeship](https://img.shields.io/codeship/dc9adee0-9b4e-0136-cc78-3a6df96c6020.svg)
![Packagist](https://img.shields.io/packagist/l/khalyomede/matcha.svg)

<div style="text-align: center;">
    <img style="margin-left: auto; margin-right: auto;" src="https://user-images.githubusercontent.com/15908747/41511668-c68e330e-727b-11e8-89b6-c18d2d07af18.png" alt="Matcha logo" height="90px" />
</div>

<br />

![Gif of an example of usage](https://image.ibb.co/ggphNK/ice_video_20180915_004002_edit_0_3.gif)

## Summary

- [Installation](#installation)
- [Examples](#examples)
- [Full example](#full-example)
- [API](api)
- [Credits](#credits)

## Installation

In your project root folder:

```bash
composer require --dev khalyomede\matcha:0.*
```

## Examples

- [Example 1: testing if a code returns a string](#example-1-testing-if-a-code-returns-a-string)
- [Example 2: testing if a value is true](#example-2-testing-if-a-code-returns-true)
- [Example 3: testing if a code returns null](#example-3-testing-if-a-code-returns-null)
- [Example 4: testing the negativity of an expression](#example-4-testing-the-negativity-of-an-expression)

### Example 1: testing if a code returns a string

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('trim', function() {
  it('should return the same string if the string has no spaces around', function() {
    expect( trim('hello world') )->toBe()->equalTo('hello world');
  });
});

run();
```

### Example 2: testing if a value is true

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('empty', function() {
  it('should return true if the string has no characters', function() {
    expect( empty('') )->toBe()->true();
  });
});

run();
```

### Example 3: testing if a code returns false

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('isset', function() {
  it('should return false if the variable does not exists', function() {
    expect( isset($GLOBALS['php6']) )->toBe()->false();
  });
});

run();
```

### Example 4: testing the negativity of an expression

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('array-sum', function() {
  it('should not return null', function() {
    expect( array_sum([1, 2, 3]) )->not()->toBe()->null();
  });
});

run();
```

## Full example

This example is intended to show you how can all of these function can be mixed together.

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('trim', function() {
  it('should return a string when triming a string', function() {
    expect(trim('hello world'))->toBe()->aString();
  });

  it('should return a string even if triming null', function() {
    expect(trim(null))->toBe()->aString();
  });

  it('should return the same string when triming a string without spaces around', function() {
    expect(trim('hello world'))->toBe()->equalTo('hello world');
  });

  it('should return the string without spaces around if triming a string with spaces around', function() {
    expect(trim(' hello world '))->toBe()->equalTo('hello world');
  });
});

describe('empty', function() {
  it('should return true if checking null', function() {
    expect(empty(null))->toBe()->strictly()->true();
  });

  it('should return true if checking false', function() {
    expect(empty(false))->toBe()->true();
  });

  it('should return true if checking an empty array', function() {
    expect(empty([]))->toBe()->true();
  });
});

describe('isset', function() {
  it('should return false if a variable is not set', function() {
    expect(isset($php6))->toBe()->false();
  });

  it('should return true if an array is set', function() {
    expect(isset($_GET))->toBe()->true();
  });
});

run();
```

## API

- [`expect()`](#expect)
  - [`not`](#not)
  - [`strictly`](#strictly)
  - [`toBe`](#tobe)
  - [`toThrow`](#toThrow)
  - [`a`](#a)
  - [`an`](#an)
  - [`anInstanceOf`](#aninstanceof)
  - [`equalTo`](#equalto)
  - [`null`](#null)
  - [`true`](#true)
  - [`false`](#false)

## Modifiers

Modifers will help you customize your tests using negations and strict flags.

- [Negation](#negation)
- [Strict check](#strict-check)

### Negation

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('sprintf', function() {
  it('should not be equal to the parameterized string', function() {
    $string = 'Hello %s';

    expect(sprintf($string, 'John'))->not()->toBe()->equalTo($string); 
  });
});
```

### Strick check

This example consist of 2 `it` tests: the first does not check stricly the type, and the second stricly checks the value.

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('integer', function() {
  it('1 should be equal to "1"', function() {
    expect(1)->toBe()->equalTo("1");
  });

  it('1 should strictly be equal to "1"', function() {
    expect(1)->toBe()->stricly()->equalTo("1");
  });
});
```

Running this script will display:

```bash
$ php test/integer.php
  integer
    ✔ 1 should be equal to "1"
    1) 1 should strictly not be equal to "1"

  1 passing, 1 failed (0ms)

  1) 1 should strictly be equal to "1"
     expected 1 to be stricly equal to 1
```

I made a mistake on purpose to show you how the `stricly()` modifier works. To fix this test, we should add a `not()`:

```php
// ...

describe('integer', function() {
  // ...

  it('1 should strictly not be equal to "1"', function() {
    expect(1)->not()->toBe()->stricly()->equalTo("1");
  });
});
```

Which will now display:

```bash
$ php test/integer.php
  integer
    ✔ 1 should be equal to "1"
    ✔ 1 should strictly not be equal to "1"

  2 passing (0ms)
```

**Note**

You can also use the strict check on:

- Exception checking (parent class will not match anymore)
- Instance of class (parent class will not match anymore)

## Credits

- Logo by [Made](https://thenounproject.com/made.somewhere/) from [Noun project](https://thenounproject.com/) (modified version of logo is currenctly used, check out the [original version](https://thenounproject.com/term/green-tea/952777/))