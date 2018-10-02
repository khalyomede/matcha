<?php
    /*
    MIT License

    Copyright (c) 2018 Khalyomede

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
    */

    use Khalyomede\Matcha;
    use Khalyomede\ReportLevel;
    
    if( function_exists('report') === false ) {
        /**
         * Set the report level for the current test.
         * 
         * @param string $level
         * @return void
         */
        function report(string $level): void {            
            $AVAILABLE_LEVELS = ReportLevel::availables();

            if( in_array($level, $AVAILABLE_LEVELS) === false ) {
                throw new InvalidArgumentException(sprintf('The report level should be one of the following: %s', 
                    implode(', ', $AVAILABLE_LEVELS)
                ));
            }

            Matcha::setReportLevel($level);

            return;
        }
    }
?>