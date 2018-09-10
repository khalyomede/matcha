<?php

require(__DIR__ . '/../vendor/autoload.php');

use function Khalyomede\Style\expect;

describe('datetime', function() {
    it('should return a DateTime instance', function() {
        expect(new DateTime)->toBe()->anInstanceOf('DateTime');
    });
});

run();

?>