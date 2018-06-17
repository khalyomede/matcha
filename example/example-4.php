<?php

require(__DIR__ . '/../vendor/autoload.php');

describe('pdo', function() {
    it('should throw an ArgumentCountError if it has not the correct argument count', function() {
        expect(function() {
            $pdo = new PDO();
        })->toThrow('ArgumentCountError');
    });
});

?>