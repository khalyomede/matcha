<?php
    use function Khalyomede\Style\expect;

    describe('count', function() {
        it('should return the correct number of element in an array', function() {
            expect(count([1, 2, 3]))->toBe()->equalTo(3);
        });

        it('should return 0 for an empty array', function() {
            expect(count([]))->toBe()->equalTo(0);
        });
    });
?>