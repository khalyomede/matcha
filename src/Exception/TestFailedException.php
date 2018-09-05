<?php
    namespace Khalyomede\Exception;

    use Exception;

    /**
     * Exception that should be thrown whenever a test failed.
     * 
     * @see Khalyomede\Matcha
     * @example 
     * require(__DIR__ . '/vendor/autoload.php');
     * 
     * use Khalyomede\Test\TestFailedException;
     * 
     * if( true === false ) {
     *   throw (new TestFailedException)->expected(true)->actual(false);
     * }
     */
    class TestFailedException extends Exception {
        /**
         * Settle that the test was checking the equality of the actual and expected values.
         * 
         * @var int
         */
        const TEST_EQUALITY = 1;

        /**
         * Settle that the test was checking the type of the actual value.
         * 
         * @var int
         */
        const TEST_TYPE = 2;

        /**
         * Settle that the test was checking the instance class of the actual value.
         */
        const TEST_INSTANCE = 3;

        /**
         * Settle that the test was checking if the expected value throwed an exception.
         */
        const TEST_EXCEPTION = 4;

        /**
         * Settle that the test was checking if the expected value throwed a correct message exception.
         */
        const TEST_EXCEPTION_MESSAGE = 5;

        const ALLOWED_TEST_TYPES = [1,2,3,4,5];

        /**
         * Stores the expected result of the test.
         * 
         * @var mixed
         */
        protected $expected;

        /**
         * Stores the actual result of the test.
         * 
         * @var mixed
         */
        protected $actual;

        /**
         * Stores whether the test was positively checking the expected result or not.
         * 
         * @var bool
         */
        protected $positive_test;

        /**
         * Stores the type of test.
         * 
         * @var int
         * @see static::TEST_EQUALITY
         */
        protected $test_type;

        /**
         * Stores whether the comparison is strict (usually, triple equal ===) or not.
         * 
         * @var bool
         */
        protected $strict_test;

        /**
         * Constructor.
         * 
         * @param string    $message    The message of the exception.
         * @param int       $code       The error code attached to the exception.
         * @param Exception $previous   The previous exception catched (to improve the stack trace debug).
         */
        public function __construct($message, $code = 0, Exception $previous = null) {
            $this->expected = '';
            $this->actual = '';
            $this->positive_test = true;
            $this->test_type = null;
            $this->strict_test = false;

            parent::__construct($message, $code, $previous);
        }

        /**
         * Stores the expected result of the test.
         * 
         * @param mixed $expected   The expected result of the test.
         * @return Khalyomede\Exception\TestFailedException
         */
        public function expected($expected): TestFailedException {
            $this->expected = $expected;
            
            return $this;
        }

        /**
         * Stores the actual result of the test.
         * 
         * @param mixed $actual The actual result of the test.
         * @return Khalyomede\Exception\TestFailedException
         */
        public function actual($actual): TestFailedException {
            $this->actual = $actual;
            
            return $this;
        }

        /**
         * Stores the fact that the test check negatively the expected value.
         * 
         * @return Khalyomede\Exception\TestFailedException
         */
        public function negativeTest(): TestFailedException {
            $this->positive_test = false;

            return $this;
        }

        /**
         * Stores the fact that the test check is strict (usually using the triple equal ===).
         * 
         * @return Khalyomede\Exception\TestFailedException
         */
        public function strictTest(): TestFailedException {
            $this->strict_test = true;
            
            return $this;
        }

        /**
         * Stores the type of check.
         * 
         * @param int   $type   The type of checking.
         * @return Khalyomede\Exception\TestFailedException
         * @throws InvalidArgumentException If the type of checking is not supported.
         * @see static::TEST_POSITIVITY
         */
        public function testType(int $type): TestFailedException {            
            if( in_array($type, static::ALLOWED_TEST_TYPES) === false ) {
                throw new InvalidArgumentException(sprintf('The test type should be either %s', array_join(', ', [
                    'static::TEST_EQUALITY',
                    'static::TEST_TYPE'
                ])));
            }

            $this->test_type = $type;

            return $this;
        }

        /**
         * Return the expected result of the test (it should have been stored before).
         * 
         * @return mixed
         */
        public function getExpected() {
            return $this->expected;
        }

        /**
         * Return the actual result of the test (it should have been stored before).
         * 
         * @return mixed
         */
        public function getActual() {
            return $this->actual;
        }

        /**
         * Returns true if the test was positively checking the expected value, else returns false.
         * 
         * @return bool
         */
        public function testIsPositive(): bool {
            return $this->positive_test;
        }

        /**
         * Returns true if the test was strictly checking the expected value.
         * 
         * @return bool
         */
        public function testIsStrict(): bool {
            return $this->strict_test;
        }

        /**
         * Returns true if the test was chekcing the equality of the expected and actual value.
         * 
         * @return bool
         */
        public function isCheckingEquality(): bool {
            return $this->test_type === static::TEST_EQUALITY;
        }

        /**
         * Returns true if the test was checking the equality of the actual value, else returns false.
         * 
         * @return bool
         */
        public function isCheckingType(): bool {
            return $this->test_type === static::TEST_TYPE;
        }

        /**
         * Returns true if the test was checking the instance of the actual value, else returns false.
         * 
         * @return bool
         */
        public function isCheckingInstance(): bool {
            return $this->test_type === static::TEST_INSTANCE;
        }

        /**
         * Returns true if the test was checking that the expected value throw an exception, else returns false.
         * 
         * @return bool
         */
        public function isCheckingException(): bool {
            return $this->test_type === static::TEST_EXCEPTION;
        }

        /**
         * Returns true if the test was checking that the expected value was the message of a thrown exception, else returns false.
         * 
         * @return bool
         */
        public function isCheckingExceptionMessage(): bool {
            return $this->test_type === static::TEST_EXCEPTION_MESSAGE;
        }
    }
?>