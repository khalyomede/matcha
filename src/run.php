<?php
    use Khalyomede\Matcha;

    if( function_exists('run') === false ) {
        function run() {
            return Matcha::run();
        }
    }
?>