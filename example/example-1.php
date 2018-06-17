<?php

require(__DIR__ . '/../vendor/autoload.php');

describe('trim', function() {
    it('should return the same string because it has no spaces around', function() {
        $string = 'hello world';

        expect(trim($string))->toBe()->equalTo($string);
    });
});

?>