<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('empty', function() {
        it('it should return true if an array is empty', function() {
            expect( empty([]) )->toBe()->aBoolean();
        });
    });

    return run();
?>