<?php
    use Khalyomede\Matcha;

    if( function_exists('it') === false ) {
        function it(string $description, callable $function): void {
            Matcha::it($description, $function);
        }
    }
?>