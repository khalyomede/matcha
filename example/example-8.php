<?php
    require(__DIR__ . '/../vendor/autoload.php');

    use function Khalyomede\Style\expect;
    
    describe('database connectivity', function() {
        it('should be reachable', function() {
            expect([
                'host' => 'ensembldb.ensembl.org', 
                'driver' => 'mysql', 
                'user' => 'anonymous'
            ])->toBe()->aDatabase()->thatIsAccessible();
        });
    });

    run();
?>