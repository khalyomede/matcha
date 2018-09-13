<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('null', function() {
        it('should return null', function() {
            expect(null)->toBe()->null();
        });
    });

    run();
?>