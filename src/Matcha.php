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
    use Khalyomede\ReportLevel;
    use InvalidArgumentException;

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
         * Stores the detail level of the reports.
         * By default it is set to "normal".
         * 
         * @var string
         * @see \Khalyomede\ReportLevel
         */
        protected static $reportLevel = ReportLevel::NORMAL;

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
         * Makes the report more detailed than usual.
         * This will set the level of detail in the report to "detailed".
         * By default it is set to "normal".
         * 
         * @return \Khalyomede\Matcha
         * @see \Khalyomede\Matcha::quiet()
         */
        public static function chatty(): Matcha {
            static::$reportLevel = ReportLevel::DETAILED;
            
            return new static;
        }

        /**
         * Makes the report les detailed than usual.
         * This will set the level of detail in the report to "reduced".
         * By default it is set to "normal".
         * 
         * @return \Khalyomede\Matcha
         * @see \Khalyomede\Matcha::chatty()
         */
        public static function quiet(): Matcha {
            static::$reportLevel = ReportLevel::REDUCED;

            return new static;
        }

        /**
         * Manually set the report level.
         * 
         * @param string $level
         * @return \Khalyomede\Matcha
         * @throws InvalidArgumentException If the report level is not valid.
         * @see \Khalyomede\ReportLevel
         */
        public static function setReportLevel(string $level): Matcha {
            if( ReportLevel::has($level) === false ) {
                throw new InvalidArgumentException(sprintf('The report level should be one of the following: %s, %s given', 
                    implode(', ', ReportLevel::availables()),
                    $level
                )); 
            }

            static::$reportLevel = $level;
            
            return new static;
        }

        /**
         * Returns true if Matcha is allowed to report test failed.
         * This is true if the report level is set to "normal" or "detailed".
         * 
         * @return bool
         * @see \Khalyomede\Matcha::$reportLevel
         * @see \Khalyomede\ReportLevel
         */
        private static function allowedToReportTestFailed(): bool {
            return in_array(static::$reportLevel, [ReportLevel::NORMAL, ReportLevel::DETAILED]);
        }

        /**
         * Returns true if Matcha can report the time elapsed for the tests.
         * This is true if the report level is set to "normal" or "detailed".
         * 
         * @return bool
         * @see \Khalyomede\Matcha::allowedToReportTestFailed()
         * @see \Khalyomede\Matcha::$reportLevel
         * @see \Khalyomede\ReportLevel
         */
        private static function allowedToReportElapsedTime(): bool {
            return static::allowedToReportTestFailed();
        }

        /**
         * Returns true if Matcha can report the name of the description of the tests.
         * This is true if the report level is set to "normal" or "detailed".
         * 
         * @return bool
         * @see \Khalyomede\Matcha::allowedToReportTestFailed()
         * @see \Khalyomede\Matcha::$reportLevel
         * @see \Khalyomede\ReportLevel
         */
        private static function allowedToReportDescription(): bool {
            return static::allowedToReportTestFailed();
        }

        /**
         * Run each test and report the errors if there is any.
         */
        public static function run(): Matcha {
            $startOfRun = microtime(true);
            $testDurationInMicroseconds = 0;

            $reporter = new ConsoleReporter;
            $reporter->setMaxEntries(static::$numberOfTest);
            $reporter->doNotClearProgress();
            $reporter->displaySeverityWithIcons();
            
            $currentDescriptionIndex = 1;
            $lastDescription = false;
            $lastTest = false;

            $completedTests = 0;
            $failedTests = 0;

            foreach( static::$tests as $description => $tests ) {
                if( static::allowedToReportDescription() === true ) {
                    $reporter->info("Running tests for \"$description\"");
                }

                $lastDescription = $currentDescriptionIndex === count(static::$tests);

                $currentTestIndex = 1;

                foreach( $tests as $expectedBehaviorString => $callableTest ) {
                    $startOfTest = microtime(true);
                    
                    try {
                        $lastTest = $currentTestIndex === count($tests);

                        $currentTestIndex++;

                        call_user_func($callableTest);

                        if( static::$reportLevel === ReportLevel::DETAILED ) {
                            $reporter->success('"it ' . $expectedBehaviorString . '" completed');
                        }

                        $completedTests++;
                    }
                    catch( TestFailedException $exception ) {
                        if( static::allowedToReportTestFailed() === true ) {
                            $reporter->error('"it ' . $expectedBehaviorString . '" failed');
                            $reporter->error($exception->getMessage());
                        }

                        $failedTests++;
                    }
                    finally {
                        $endOfTest = microtime(true);
                        $testDurationInMicroseconds += $endOfTest - $startOfTest;

                        if( $lastDescription === true && $lastTest === true ) {
                            $endOfRun = microtime(true);
                            $totalRunTimeInMicroseconds = $endOfRun - $startOfRun;
                            $extraRunTimeInMicoseconds  = round($totalRunTimeInMicroseconds - $testDurationInMicroseconds, 4);
                            $testDurationInMicroseconds = round($testDurationInMicroseconds, 4);

                            $reporter->debug("$completedTests tests completed, $failedTests tests failed");                            

                            if( static::allowedToReportElapsedTime() === true ) {
                                $reporter->debug("tests ran in $testDurationInMicroseconds sec. (+$extraRunTimeInMicoseconds sec.)");       
                            }
                        }

                        $reporter->report();
                        $reporter->advance();
                    }
                }

                $currentDescriptionIndex++;
            }

            return new static;
        }
    }
?>