<?php
    use Khalyomede\Style\Expect;

    if( function_exists('expect') === false ) {
        function expect($mixed): Expect {
            return new Expect($mixed);
        }
    }
?>