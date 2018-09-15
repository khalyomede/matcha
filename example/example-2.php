<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('empty', function() {
        it('should return true if the string has no characters', function() {
            expect( empty('') )->toBe()->true();
        });
    });

    run();
?>