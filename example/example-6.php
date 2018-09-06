<?php
    require(__DIR__ . '/../vendor/autoload.php');

    describe('useless', function() {
        it('should return null', function() {
            expect(null)->toBe()->null();
        });
    });
?>