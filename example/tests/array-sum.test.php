<?php
    use function Khalyomede\Style\expect;

    describe('array_sum', function() {
        it('should return the sum of an array of integers', function() {
            expect(array_sum([1, 2, 3]))->toBe()->equalTo(6);
        });

        it('should return 0 for an empty array', function() {
            expect(array_sum([]))->toBe()->equalTo(0);
        });
    });
?>