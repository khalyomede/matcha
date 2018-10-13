<?php
    use function Khalyomede\Style\expect;

    describe('abs', function() {
        it('should return the positive result of a calculus returning a negative value', function() {
            expect(abs(-10 + 2))->toBe()->equalTo(8);
        });

        it('should return 0 if the parameter is negative 0', function() {
            expect(abs(-0))->toBe()->equalTo(0);
        });
    });
?>