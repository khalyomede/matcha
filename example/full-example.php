<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

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
                expect(str_shuffle(null))->toBe()->aString();
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

    run();
?>