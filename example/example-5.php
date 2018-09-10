<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('datetime', function() {
        it('should throw the correct exception message if the date is invalid', function() {
            expect(function() {
                $date = new DateTime('hello world');
            })->toThrow()->theMessage('DateTime::__construct(): Failed to parse time string (hello world) at position 0 (h): The timezone could not be found in the database');
        });
    });

    run();
?>