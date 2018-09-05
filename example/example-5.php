<?php
    require(__DIR__ . '/../vendor/autoload.php');

    describe('datetime', function() {
        it('should throw an exception if the date is invalid', function() {
            expect(function() {
                $date = new DateTime('hello world');
            })->toThrow('Exception', 'Hello world');
        });
    });
?>