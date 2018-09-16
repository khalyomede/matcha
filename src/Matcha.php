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

    namespace Khalyomede;
    
    use Khalyomede\Exception\TestFailedException;
    use Khalyomede\ConsoleReporter;

    /**
     * This class deals with grouping tests and running test in batch.
     * The type of test is defined by another "style" class (for the moment, only the style Expect exists).
     */
    class Matcha {
        /**
         * Associative array that 
         * stores the tests that 
         * will be batch run.
         * 
         * @var array<mixed>
         */
        protected static $tests = [];

        /**
         * Stores the current description to help 
         * the "it" calls to be attached to the 
         * right description the the 
         * static::$tests associative array.
         * 
         * @var string
         */
        protected static $currentDescription = '';

        /**
         * Stores the number of tests, useful for the report in the console.
         * 
         * @var int
         */
        protected static $numberOfTest = 0;

        /**
         * Set the group name for the "it" calls, and execute the function that should 
         * trigger the "it" calls.
         */
        public static function describe(string $description, callable $function): Matcha {
            static::$currentDescription = $description;

            call_user_func($function);

            return new static;
        }

        /**
         * Register a test in the correct description.
         */
        public static function it(string $expectedBehaviorString, callable $function): Matcha {
            static::$tests[ static::$currentDescription ][ $expectedBehaviorString ] = $function;

            static::$numberOfTest++;

            return new static;
        }

        /**
         * Run each test and report the errors if there is any.
         */
        public static function run(): Matcha {
            $reporter = new ConsoleReporter;
            $reporter->setMaxEntries(static::$numberOfTest);
            $reporter->doNotClearProgress();

            foreach( static::$tests as $description => $tests ) {
                $reporter->info("Running tests for \"$description\"");

                foreach( $tests as $expectedBehaviorString => $callableTest ) {
                    try {
                        call_user_func($callableTest);
                    }
                    catch( TestFailedException $exception ) {
                        $reporter->error($exception->getMessage());
                    }
                    finally {
                        $reporter->report();
                        $reporter->advance();
                    }
                }
            }

            return new static;
        }
    }
?>