<?php
    require(__DIR__ . '/../vendor/autoload.php');

    describe('empty', function() {
        it('should return false if the string contains something', function() {
            expect(empty(''))->toBe()->true();
        });
    });
?>  