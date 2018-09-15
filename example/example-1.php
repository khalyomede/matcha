<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('trim', function() {
        it('should return the same string if the string has no spaces around', function() {
            expect( trim('hello world') )->toBe()->equalTo('hello world');
        });
    });

    run();
?>