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
- [Example 5: testing if a message has been displayed](#example-5-testing-if-a-message-has-been-displayed)
- [Example 6: testing if a variable returns the desired type](example-6-testing-if-a-variable-returns-the-desired-type)

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

### Example 5: testing if a message has been displayed

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('echo', function() {
  it('it should display the correct message', function() {
    expect(function() {
      echo 'hello world';
    })->toDisplay('hello world');
  });
});

run();
```

### Example 6: testing if a variable returns the desired type

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('empty', function() {
  it('it should return true if an array is empty', function() {
    expect( empty([]) )->toBe()->aBoolean();
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

- [describe](#describe)
- [expect](#expect)
  - [not](#not)
  - [strictly](#strictly)
  - [toBe](#tobe)
    - [aBoolean](#aBoolean)
    - [aDouble](#aDouble)
    - [aFloat](#aFloat)
    - [aFunction](#aFunction)
    - [anArray](#anArray)
    - [anObject](#anObject)
    - [anInstanceOf](#anInstanceOf)
    - [anInteger](#anInteger)
    - [aResource](#aResource)
    - [aString](#aString)
    - [equalTo](#equalto)
      - [false](#false)
      - [null](#null)
      - [true](#true)
  - [toDisplay](#toDisplay)
  - [toThrow](#toThrow)
    - [theException](#theException)
    - [theMessage](#theMessage)
- [it](#it)
- [run](#run)

### expect

Returns a new Expect instance.

```php
function expect($mixed): Expect
```

```php
require(__DIR__  '/../vendor/autoload.php');

use function Khalyomede\Expect;

expect( empty('hello world') );
```

```php
require(__DIR__  '/../vendor/autoload.php');

use function Khalyomede\Expect;

expect(function() {
  throw new Exception('exception manually thrown');
});
```

### not

Asserts that we expect the inverse of the test.

```php
public function not(): Expect
```

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('empty', function() {
  it('should not return true if the string is not empty', function() {
    expect( empty('hello world') )->not()->toBe()->true();
  });
});

run();
```

### strictly

Asserts that we expect the test to be also type-tested (this will prevent from PHP to perform implicit cast when running the test).

```php
public function strictly(): Expect
```

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('int cast', function() {
  it('should return the integer equivalent of the string representation of a number', function() {
    expect((int) '1')->toBe()->strictly()->equalTo(1);
  });
});

run();
```

### toBe

Asserts that we are testing an equality.

```php
public function toBe(): Expect
```

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('trim', function() {
  it('should return the same string if it has no spaces around', function() {
    expect( trim('hello world') )->toBe()->equalTo('hello world');
  });
});

run();
```

### equalTo

Asserts that we are testing an equality against a particular value.

```php
public function equalTo($mixed): Expect
```

```php
require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('implicit cast', function() {
  it('should implicitly cast the string representation of a number', function() {
    expect('1')->toBe()->equalTo(1)
  });
});

run();
```

## Credits

- Logo by [Made](https://thenounproject.com/made.somewhere/) from [Noun project](https://thenounproject.com/) (modified version of logo is currenctly used, check out the [original version](https://thenounproject.com/term/green-tea/952777/))