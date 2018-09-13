<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('empty', function() {
        it('should return false if the string contains something', function() {
            expect(empty(''))->toBe()->true();
        });
    });

    run();
?>  