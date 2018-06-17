# Matcha

Test library for PHP.

## Summary

- [Installation](#installation)
- [Getting started](#getting-started)
- [Examples](#examples)
- [Full example](#full-example)
- [Modifiers](#modifiers)

## Installation

In your project, include the dependency for Matcha:

```bash
composer require khalyomede\matcha:0.*
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
  
  1 passing (0ms)
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

  1 passing (0ms)
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

  1 passing (0ms)
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

  1 passing (0ms)
```

## Full example

This example is intended to show you how can all of these function can be mixed together.

```php
    
```

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