<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('json', function() {
        it('should be a valid json string', function() {
            expect('{"hello": "world"}')->toBe()->aString()->inJsonFormat();
        });
    });

    return run();
?>