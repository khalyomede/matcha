<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('array-sum', function() {
        it('should not return null', function() {
            expect( array_sum([1, 2, 3]) )->not()->toBe()->null();
        });
    });

    return run();
?>