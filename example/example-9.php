<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;
    use Khalyomede\ReportLevel;

    describe('array', function() {
        it('should merge two arrays', function() {
            expect( array_merge([1, 2, 3], [4, 5, 6]) )->toBe()->equalTo([1, 2, 3, 4, 5, 6]);
        });

        it('should diff two array', function() {
            expect( array_count_values([1, 1, 3]) )->toBe()->equalTo([1 => 2, 3 => 1]);
        });

        it('should shuffle an array', function() {
            $array = [1, 2];

            expect( shuffle($array) )->toBe()->anArray();
        });
    });

    report('detailed');
    // report(ReportLevel::DETAILED);

    return run();
?>