<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('fopen', function() {
        it('should be a resource', function() {
            expect( fopen('./example/example-7.php', 'r') )->toBe()->aResource();
        });
    });

    run();
?>