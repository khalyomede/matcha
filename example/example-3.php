<?php

require(__DIR__ . '/../vendor/autoload.php');

describe('datetime', function() {
    it('should return a DateTime instance', function() {
        expect(new DateTime)->toBe()->anInstanceOf('DateTime');
    });
});

?>