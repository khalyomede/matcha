<?php
    namespace Khalyomede\Style;

    use Khalyomede\Exception\TestFailedException;
    use Khalyomede\Exception\TestFailedMessage;
    use Khalyomede\TestType;
    use Throwable;
    use Exception;
    use InvalidArgumentException;

    /**
     * Throw errors that will be catched by Matcha::it() and reported in the console according to the test order.
     */
    class Expect {
        protected $testsTheEquality;
        protected $testsTheEqualityAgainstAValue;
        protected $testsTheEqualityAgainstAnInstance;
        protected $testsException;
        protected $testsExceptionThrown;
        protected $testsExceptionMessage;
        protected $expected;
        protected $actual;

        public function __construct($actual) {
            if( is_callable($actual) === true ) {
                try {
                    $this->actual = call_user_func($actual);
                }
                catch( Throwable $exception ) {
                    $this->actual = $exception;
                }
            }
            else {
                $this->actual = $actual;
            }
        }

        public function toBe(): Expect {
            $this->testsTheEquality = true;

            return $this;
        }

        public function toThrow(): Expect {
            $this->testsException = true;

            return $this;
        }

        public function theException(string $exception): Expect {
            $this->testsExceptionThrown = true;
            $this->expected = $exception;
            $this->actual = get_class($this->actual);

            return $this;
        }

        public function theMessage(string $message): Expect {
            $this->testsExceptionMessage = true;
            $this->expected = $message;
            $this->actual = $this->actual->getMessage();

            return $this;
        }

        public function equalTo($expected): Expect {
            $this->testsTheEqualityAgainstAValue = true;
            $this->expected = $expected;

            return $this;
        }

        public function anInstanceOf(string $expected): Expect {
            $this->testsTheEqualityAgainstAnInstance = true;
            $this->expected = $expected;

            return $this;
        }

        /**
         * Evaluate the order to determine if it should report an error to Matcha::if() by throwing an exception if the test failed.
         */
        public function __destruct() {
            $message = (new TestFailedMessage)->expected($this->expected)
                ->actual($this->actual);

            if( $this->testsTheEquality === true ) {
                if( $this->testsTheEqualityAgainstAValue === true ) {
                    if( $this->expected != $this->actual ) {
                        throw new TestFailedException( $message->checking(TestType::SAME_VALUE)->build() );
                    }
                }
                else if( $this->testsTheEqualityAgainstAnInstance === true ) {
                    if( $this->actual instanceof $this->expected === false ) {
                        throw new TestFailedException( $message->checking(TestType::INSTANCE_OF)->build() );
                    }
                }
            }
            else if( $this->testsException === true ) {
                if( $this->testsExceptionThrown === true ) {
                    if( $this->expected !== $this->actual ) {
                        throw new TestFailedException( $message->checking(TestType::SAME_EXCEPTION)->build() );
                    }
                }
                else if( $this->testsExceptionMessage === true ) {
                    if( $this->expected !== $this->actual ) {
                        throw new TestFailedException( $message->checking(TestType::SAME_EXCEPTION_MESSAGE)->build() );
                    }
                }
            } 
        }
    }
?>