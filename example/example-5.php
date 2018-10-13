<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;

    describe('echo', function() {
        it('it should display the correct message', function() {
            expect(function() {
                echo 'hello world';
            })->toDisplay('hello world');
        });
    });

    return run();
?>