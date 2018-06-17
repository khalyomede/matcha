<?php
    use Khalyomede\Matcha;

    if( function_exists('describe') === false ) {
        function describe(string $description, callable $function): void {
            Matcha::describe($description, $function);
        }
    }
?>