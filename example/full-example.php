<?php
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
            expect(empty(null))->toBe()->true();
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
?>