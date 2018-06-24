<?php
    namespace Khalyomede;

    use Exception;
    use Khalyomede\Exception\TestFailedException;

    /**
     * Checks if all the methods are ran according to your tests.
     * 
     * @example
     * require(__DIR__ . '/vendor/autoload.php');
     * 
     * use Khalyomede\Matcha;
     * use Me\YourClass;
     * 
     * describe('YourClass', function() {
     *  it('should be set', function() {
     *    that(new YourClass)->should()->exist();
     *  });
     * });
     */
    class Matcha {
        /**
         * Stores the delimiter for the displayed messages in the console.
         * 
         * @var string
         */
        const DELIMITER = ' ';

        /**
         * Store the nested levels of describes for display purposes.
         * 
         * @var int
         */
        protected static $nesting_level = 1;

        /**
         * Stores the time elapsed during the tests (e.g. the time spent inside the callable of "it" methods) in microseconds.
         * 
         * @var int
         */
        protected static $elapsed_time = 0;

        /**
         * Stores the number of successful tests.
         * 
         * @var int
         */
        protected static $successful_tests = 0;

        /**
         * Stores the number of failed tests.
         * 
         * @var int
         */
        protected static $failed_tests = 0;

        /**
         * Stores the failures to displayed them when all the tests have been completed.
         * 
         * @var array<Exception>
         */
        protected static $failures = [];

        /**
         * Stores the index of the current failure for display purposes.
         * 
         * @var int
         */
        protected static $failure_index = 1;

        /**
         * Stores the start time of the hole test.
         * 
         * @var int
         */
        protected static $start_time = 0;

        /**
         * Stores the end time of the end of the hole test.
         * 
         * @var int
         */
        protected static $end_time = 0;

        /**
         * Display the descrption and continue the testing algorithm.
         * 
         * @param   string      $description    The message to display in console.
         * @param   callable    $function       The function to call to continue the algorithm.
         * @return  Khalyomede\Matcha
         */
        public static function describe(string $description, callable $function): Matcha {
            static::setStartTimeIfItIsTheFirstDescribe();
            static::printDescribe($description);
            static::$nesting_level++;

            call_user_func($function);

            static::$nesting_level--;
            static::setEndTImeIfItIsTheLastDescribe();
            static::reportIfItIsTheLastDescribe();
            
            return new static;
        }

        /**
         * Execute a function and test if it ran without throwing any exception by displaying the result in console.
         * 
         * @param string    $description    The message that best describe the test(s).
         * @param callable  $function       The function that will execute the test(s).
         * @return Khalyomede\Matcha
         */
        public static function it(string $description, callable $function): Matcha {
            $starting_time = microtime(true);
            
            try {
                call_user_func($function);

                static::printSuccessTest($description);
                static::$successful_tests++;
            }
            catch( Exception $exception ) {
                static::printFailedTest($description);
                static::registerFailureForReport($description, $exception);
                static::$failed_tests++;
            }
            finally {
                static::increaseElapsedTime($starting_time);
            }
            
            return new static;
        }

        /**
         * Print the message by computing the required tabulations needed.
         * 
         * @param string    $message    The message to print in console.
         * @return void
         */
        private static function printDescribe(string $message): void {
            echo(static::getDescribeMessage($message) . PHP_EOL);
        }

        /**
         * Print in console the message that indicate the tested test has been successful.
         * 
         * @param string    $description    The message that describe the test.
         * @return void
         */
        private static function printSuccessTest(string $description): void {
            echo static::getSuccessTestMessage($description) . PHP_EOL;
        }

        /**
         * Print in consoel the message that indicate the tested test has been invalid.
         * 
         * @param string    $description    The message that describe the test.
         * @return void
         */
        private static function printFailedTest(string $description): void {
            echo static::getFailedTestMessage($description) . PHP_EOL;
        }

        /**
         * Return the formatted message with the right number of tabulations.
         * 
         * @param string    $message    The message that is intended to be printed in console.
         * @return string
         */
        private static function getDescribeMessage(string $message): string {
            return str_repeat(static::DELIMITER, static::$nesting_level) . $message;
        }

        /**
         * Returns the begining, consisting in tabulations, of the test message.
         * 
         * @return string
         */
        private static function getTestMessageBegining(): string {
            return str_repeat(static::DELIMITER, static::$nesting_level + 1);
        }

        /**
         * Return the string that indicate the test tested has been successful.
         * 
         * @param string    $message    The message that describe the test.
         * @return string
         */
        private static function getFailedTestMessage(string $message): string {
            $result = static::getTestMessageBegining() . static::$failure_index . ') ' . $message;

            static::$failure_index++;

            return $result;
        }

        /**
         * Return the string that indicate the test tested has been invalid.
         * 
         * @param string    $message    The message that describe the test.
         * @return string
         */
        private static function getSuccessTestMessage(string $message): string {
            return static::getTestMessageBegining() . '✔ ' . $message;
        }

        /**
         * Increase the elapsed time by the difference between the given starting time and the current time.
         * 
         * @param string    $starting_time  The starting time of the test.
         * @return Khalyomede\Mocha
         */
        private static function increaseElapsedTime($starting_time): Matcha {
            static::$elapsed_time += microtime(true) - $starting_time;

            return new static;
        }

        /**
         * If it is the end of the tests, meaning we reached the last "describe", we report the number of successful/failed tests and the time elapsed.
         * 
         * @return void
         */
        private static function reportIfItIsTheLastDescribe(): void {
            if( static::$nesting_level === 1 ) {
                echo static::report();
                exit(static::exitValue());
            }
        }

        /**
         * Return the string that display the number of successful and failed tests, with the time elapsed.
         * 
         * @return string
         */
        private static function report(): string {
            $report = PHP_EOL . static::DELIMITER;
            
            if( static::$successful_tests > 0 ) {
                $report .= static::$successful_tests . " passing";
            }

            if( static::$failed_tests > 0 ) {
                if( static::$successful_tests > 0 ) {
                    $report .= ', ';
                }

                $report .= static::$failed_tests . " failed";
            }

            $report .= ' (' . static::elapsedTime() . 'ms)' . PHP_EOL;

            $report .= PHP_EOL . static::DELIMITER . 'Done in ' . static::testDurationValue() . static::testDurationUnit() . PHP_EOL;

            if( static::$failed_tests > 0 ) {
                $report .= PHP_EOL;
            }

            foreach( static::$failures as $index => $failure ) {
                if( $failure['exception'] instanceof TestFailedException ) {
                    $report .= static::DELIMITER . ($index + 1) . ") " . $failure['description'] . PHP_EOL;
                    $report .= str_repeat(static::DELIMITER, 3) . ' ' . static::failureMessage($failure['exception']) . PHP_EOL;
                }
                else {
                    throw $failure['exception'];
                }
            }

            return $report;
        }

        /**
         * Return the time elapsed for all the tests.
         * 
         * @return int
         */
        private static function elapsedTime(): string {
            return round(static::$elapsed_time * 1000, 0);
        }

        /**
         * Register the failures in an array to display the error in the report that is displayed when all the tests have been completed.
         * 
         * @param string    $description    The descrption of the failed test.
         * @param Exception $exception      The exception to report.
         * @return Khalyomede\Matcha
         */
        private static function registerFailureForReport(string $description, Exception $exception): Matcha {
            static::$failures[] = [
                'description' => $description,
                'exception' => $exception
            ];

            return new static;
        }

        /**
         * Get the formatted failure message.
         * 
         * @param TestFailedException   $exception  The exception to format.
         * @return string 
         */
        private static function failureMessage(TestFailedException $exception): string {
            $message = '';
            $expected = $exception->getExpected();
            $actual = $exception->getActual();

            if( is_object($expected) === true ) {
                $expected = get_class($expected);
            }
            else if( is_null($expected) === true ) {
                $expected = 'null';
            }

            if( is_object($actual) === true ) {
                $actual = get_class($actual);
            }
            else if( is_null($actual) === true ) {
                $actual = 'null';
            }
            
            if( $exception instanceof TestFailedException ) {                
                $message = "expected $expected";
                
                if( $exception->testIsPositive() === true ) {
                    $message .= " to";
                }
                else {
                    $message .= " not to";
                }

                if( $exception->testIsStrict() === true ) {
                    $message .= " strictly";
                }

                if( $exception->isCheckingEquality() === true ) {
                    $message .= " be equal to";
                }
                else if( $exception->isCheckingType() === true ) {
                    $message .= " be of type";
                }
                else if( $exception->isCheckingInstance() === true ) {
                    $message .= " be an instance of";
                }
                else if( $exception->isCheckingException() === true ) {
                    $message .= " be an instance of";
                }

                $message .= " $actual";
            }
            else {
                throw $exception;
            }

            return $message;
        }

        /**
         * Return 0 if no test failed, else return -1 (error return value to let the program be aware of the error).
         * 
         * @return int
         */
        private static function exitValue() {
            return static::$failed_tests > 0 ? -1 : 0;
        }

        /**
         * Stores the start time if it is the begining of the test.
         * 
         * @return Khalyomede\Matcha
         */
        protected static function setStartTimeIfItIsTheFirstDescribe(): Matcha {
            if( static::$nesting_level === 1 ) {
                static::$start_time = microtime(true) * 1000;
            }
            
            return new static;
        }

        /**
         * Stores the end time if it is the end of the test.
         * 
         * @return Khalyomede\Matcha
         */
        protected static function setEndTImeIfItIsTheLastDescribe(): Matcha {
            if( static::$nesting_level === 1 ) {
                static::$end_time = microtime(true) * 1000;
            }

            return new static;
        }

        /**
         * Get the raw elapsed duratin time for the hole test.
         * 
         * @return int
         */
        private static function testDuration(): int {
            return static::$end_time - static::$start_time;
        }

        /**
         * Get the elapsed duration time for the hole test.
         * 
         * @return int
         * @see static::testDurationUnit()
         */
        protected static function testDurationValue(): int {
            $duration = static::testDuration();

            if( $duration > 1000 ) {
                $duration /= 1000;
            }

            return round($duration);
        }

        /**
         * Get the unit of the elapsed duration for the hole test.
         * 
         * @return string
         * @see static::testDurationValue()
         */
        private static function testDurationUnit(): string {
            $duration = static::testDuration();
            $unit = 'ms';

            if( $duration > 1000 ) {
                $unit = 's';
            }

            return $unit;
        }
    }
?>