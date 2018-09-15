# Matcha

Test library for PHP.


![Packagist](https://img.shields.io/packagist/v/khalyomede/matcha.svg)
![PHP from Packagist](https://img.shields.io/packagist/php-v/khalyomede/matcha.svg)
![Packagist](https://img.shields.io/packagist/l/khalyomede/matcha.svg)

<div style="text-align: center;">
    <img style="margin-left: auto; margin-right: auto;" src="https://user-images.githubusercontent.com/15908747/41511668-c68e330e-727b-11e8-89b6-c18d2d07af18.png" alt="Matcha logo" height="90px" />
</div>

<br />

![Gif of an example of usage](https://image.ibb.co/ggphNK/ice_video_20180915_004002_edit_0_3.gif)

## Summary

- [Installation](#installation)
- [Getting started](#getting-started)
- [Examples](#examples)
- [Full example](#full-example)
- [API](api)
- [Modifiers](#modifiers)
- [Credits](#credits)

## Installation

In your project, include the dependency for Matcha:

```bash
composer require --dev khalyomede\matcha:0.*
```

## Getting started

Here is all you should do before actually running your tests.

1. Choose a folder to locate your tests

In my case I will store them on `/test` folder.

2. Create a test file

To test my string functions, I will put the minimal code below on the file `/test/string.php`:

```php
// test/string.php
require(__DIR__ . '/../vendor/autoload.php');

// test will be written here...
```

## Examples

- [Checking the return value](#checking-the-return-value)
- [Checking the type of a return value](#checking-the-type-of-a-return-value)
- [Checking the type of an object](#checking-the-type-of-an-object)
- [Checking if a portion of code will throw an exception](#checking-if-a-portion-of-code-will-throw-an-exception)
- [Checking if a portion of code will throw an exception with the desired message](#checking-if-a-portion-of-code-will-throw-an-exception-with-the-desired-message)
- [Checking if a value is null](#checking-if-a-value-is-null)
- [Checking if a value is true](#checking-if-a-value-is-true)

### Checking the return value

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('trim', function() {
  it('should return the same string because it has no spaces around', function() {
    $string = 'hello world';

    expect(trim($string))->toBe()->equalTo($string);
  });
});
```

Running this script will display:

```bash
$ php test/string.php
  trim
    ✔ should return the same string because it has no spaces around
  
  1 passing (1ms)
```

### Checking the type of a return value

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('trim', function() {
  it('should return a string', function() {
    expect(trim('hello world'))->toBe()->a('string');
  });
});
```

Running this script will display:

```bash
$ php test/string.php
  trim
    ✔ should return a string

  1 passing (1ms)
```

### Checking the type of an object

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('datetime', function() {
  it('should return a DateTime instance', function() {
    expect(new DateTime)->toBe()->anInstanceOf('DateTime');
  });
});
```

Running this script will display:

```bash
$ php test/string.php
  datetime
    ✔ should return a DateTime instance

  1 passing (15ms)
```

### Checking if a portion of code will throw an exception

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('pdo', function() {
  it('should throw an ArgumentCountError if it has not the correct argument count', function() {
    expect(function() {
        $pdo = new PDO();
    })->toThrow('ArgumentCountError');
  });
});
```

Running this script will display:

```bash
$ php test/string.php
  pdo
    ✔ should throw an ArgumentCountError if it has not the correct argument count

  1 passing (56ms)
```

### Checking if a portion of code will throw an exception with the desired message

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('datetime', function() {
  it('should throw an exception if the date is invalid', function() {
    expect(function() {
      $date = new DateTime('hello world');
    })->toThrow('Exception', 'Hello world');
  });
});
```

Running this script will display:

```
$ php example/example-5.php
 datetime
   1) should throw an exception if the date is invalid

 1 failed (2ms)

 Done in 1ms

 1) should throw an exception if the date is invalid
    expected "DateTime::__construct(): Failed to parse time string (hello world) at position 0 (h): The timezone could not be found in the database" to be equal to the exception message "Hello world"
```

### Checking if a value is null

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('null', function() {
  it('should return null', function() {
    expect(null)->toBe()->null();
  });
});
```

Running this script will display:

```
$ php example/example-6.php
 null
   ✔ should return null

 1 passing (1ms)

 Done in 1ms
```

### Checking if a value is a resource

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('fopen', function() {
  it('should be a resource', function() {
    expect( fopen('./example/example-7.php', 'r') )->toBe()->a('resource');
  });
});
```

Running this script will display:

```
$ php example/example-7.php
 fopen
   ✔ should be a resource

 1 passing (1ms)

 Done in 1ms
```

### Checking if a value is true

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('empty', function() {
  it('should return false if the string contains something', function() {
    expect(empty(''))->toBe()->true();
  });
});
```

```
$ php example/example-8.php
 empty
   ✔ should return false if the string contains something

 1 passing (1ms)

 Done in 0ms
```

## Full example

This example is intended to show you how can all of these function can be mixed together.

```php
require(__DIR__ . '/../vendor/autoload.php');

describe('php', function() {
  describe('trim', function() {
    it('should return the same string', function() {
      $input = 'hello world';
      
      expect(trim($input))->toBe()->equalTo($input);
    });

    it('should trim multiple spaces around', function() {
      expect(trim('  hello world '))->toBe()->equalTo('hello world');
    });
  });

  describe('str_shuffle', function() {
    it('should not return the same string', function() {
      $input = 'hello world';

      expect(str_shuffle($input))->not()->toBe()->equalTo($input);
    });

    it('should return a string if the input is null', function() {
      expect(str_shuffle(null))->toBe()->a('string');
    });
  });

  describe('round', function() {
    it('should strictly return the rounded number', function() {
      expect(round(42.5))->toBe()->strictly()->equalTo(43.0); // round returns a float and not an integer
    });
  });

  describe('PDO', function() {
    it('should throw an exception if the database information are invalid', function() {
      expect(function() {
        $pdo = new PDO('mysql:host=unknown;dbname=whatever;charset=CP51', 'me', '123supersecure');
      })->strictly()->toThrow('PDOException');
    });
  });
});
```

Running this script will display:

```bash
$ php example/full-example.php
 php
  trim
    ✔ should return the same string
    ✔ should trim multiple spaces around
  str_shuffle
    ✔ should not return the same string
    ✔ should return a string if the input is null
  round
    ✔ should strictly return the rounded number
  PDO
    ✔ should throw an exception if the database information are invalid

 6 passing (86ms)
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