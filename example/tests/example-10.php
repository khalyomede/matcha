<?php
    use function Khalyomede\Style\expect;

    describe('abs', function() {
        it('it should give the absolute value for a positive value', function() {
            expect(abs(-10 + 2))->toBe()->equalTo(8);
        });

        it('should give the absolute value for a positive value', function() {
            expect(abs(10 + 2))->toBe()->equalTo(12);
        });
    });
?>