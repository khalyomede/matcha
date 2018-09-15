<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('isset', function() {
        it('should return false if the variable does not exists', function() {
            expect( isset($GLOBALS['php6']) )->toBe()->false();
        });
    });

    run();
?>