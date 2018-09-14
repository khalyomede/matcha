<?php

require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('trim', function() {
    it('should return the same string because it has no spaces around', function() {
        $string = 'test';

        expect(trim($string))->toBe()->equalTo($string);
    });
});

run();

?>