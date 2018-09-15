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
        protected $testsTheEqualityAgainstTrue;
        protected $testsTheEqualityAgainstFalse;
        protected $testsTheEqualityAgainstAValue;
        protected $testsTheEqualityAgainstAnInstance;
        protected $testsException;
        protected $testsExceptionThrown;
        protected $testsExceptionMessage;
        protected $testsNullity;
        protected $testsTypeResource;
        protected $testsTypeString;
        protected $testsTypeArray;
        protected $testsTypeInteger;
        protected $testsTypeFloat;
        protected $testsTypeDouble;
        protected $isAFunction;
        protected $expected;
        protected $actual;
        protected $negativeTest;
        protected $strictTest;

        public function __construct($actual) {
            if( is_callable($actual) === true ) {
                $this->isAFunction = true;

                try {
                    $this->actual = call_user_func($actual);
                }
                catch( Throwable $exception ) {
                    $this->actual = $exception;
                }
            }
            else {
                $this->isAFunction = false;
                $this->actual = $actual;
            }
        }

        public function toBe(): Expect {
            $this->testsTheEquality = true;

            return $this;
        }

        public function true(): Expect {
            $this->testsTheEqualityAgainstTrue = true;
            $this->expected = true;

            return $this;
        }

        public function false(): Expect {
            $this->testsTheEqualityAgainstFalse = true;
            $this->expected = false;

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

        public function null(): Expect {
            $this->testsNullity = true;
            $this->expected = null;

            return $this;
        }

        public function aResource(): Expect {
            $this->testsTypeResource = true;
            $this->expected = "resource";

            return $this;
        }

        public function aString(): Expect {
            $this->testsTypeString = true;
            $this->expected = "";

            return $this;
        }

        public function anInteger(): Expect {
            $this->testsTypeInteger = true;
            
            return $this;
        }

        public function not(): Expect {
            $this->negativeTest = true;

            return $this;
        }

        public function strictly(): Expect {
            $this->strictTest = true;

            return $this;
        }

        public function anArray(): Expect {
            $this->testsTypeArray = true;

            return $this;
        }

        public function aFloat(): Expect {
            $this->testsTypeFloat = true;

            return $this;
        }

        public function aDouble(): Expect {
            $this->testsTypeDouble = true;

            return $this;
        }

        public function aFunction(): Expect {
            $this->testsTypeFunction = true;

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
                    if( $this->negativeTest === true ) {
                        if( $this->strictTest === true ) {
                            if( $this->expected === $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::SAME_VALUE)->negatively()->strictly()->build() );
                            }
                        }
                        else {
                            if( $this->expected == $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::SAME_VALUE)->negatively()->build() );
                            }
                        }
                    }
                    else {
                        if( $this->strictTest === true ) {
                            if( $this->expected !== $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::SAME_VALUE)->strictly()->build() );
                            }
                        }
                        else {
                            if( $this->expected != $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::SAME_VALUE)->build() );
                            }
                        }
                    }
                }
                else if( $this->testsTheEqualityAgainstAnInstance === true ) {
                    $equal_instances = $this->actual instanceof $this->expected;
                    if( $this->negativeTest === true ) {
                        if( $equal_instances === true ) {
                            throw new TestFailedException( $message->checking(TestType::INSTANCE_OF)->negatively()->build() );
                        }
                    }
                    else {
                        if( $equal_instances === false ) {
                            throw new TestFailedException( $message->checking(TestType::INSTANCE_OF)->build() );
                        }
                    }
                }
                else if( $this->testsNullity === true ) {
                    $is_null = is_null($this->actual);

                    if( $this->negativeTest === true ) {
                        if( $is_null === true ) {
                            throw new TestFailedException( $message->checking(TestType::NULLITY)->negatively()->build() );   
                        }
                    }
                    else {
                        if( $is_null !== true ) {
                            throw new TestFailedException( $message->checking(TestType::NULLITY)->build() );
                        }
                    }
                }
                else if( $this->testsTypeResource === true ) {
                    $is_resource = is_resource($this->actual);

                    if( $this->negativeTest === true ) {
                        if( $is_resource === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_RESOURCE)->negatively()->build() );
                        }   
                    }
                    else {
                        if( $is_resource !== true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_RESOURCE)->build() );
                        }
                    }
                }
                else if( $this->testsTheEqualityAgainstTrue === true ) {
                    if( $this->negativeTest === true ) {
                        if( $this->strictTest === true ) {
                            if( $this->expected === $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::VALUE_TRUE)->negatively()->strictly()->build() );
                            }
                        }
                        else {
                            if( $this->expected == $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::VALUE_TRUE)->negatively()->build() );
                            }
                        }
                    }
                    else {
                        if( $this->strictTest === true ) {
                            if( $this->expected !== $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::VALUE_TRUE)->strictly()->build() );
                            }
                        }
                        else {
                            if( $this->expected != $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::VALUE_TRUE)->build() );
                            }
                        }
                    }
                }
                else if( $this->testsTheEqualityAgainstFalse === true ) {
                    if( $this->negativeTest === true ) {
                        if( $this->strictTest === true ) {
                            if( $this->expected === $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::VALUE_FALSE)->negatively()->strictly()->build() );
                            }
                        }
                        else {
                            if( $this->expected == $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::VALUE_FALSE)->negatively()->build() );
                            }
                        }
                    }
                    else {
                        if( $this->strictTest === true ) {
                            if( $this->expected !== $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::VALUE_FALSE)->strictly()->build() );
                            }
                        }
                        else {
                            if( $this->expected != $this->actual ) {
                                throw new TestFailedException( $message->checking(TestType::VALUE_FALSE)->build() );
                            }
                        }
                    }
                }
                else if( $this->testsTypeString === true ) {
                    if( $this->negativeTest === true ) {
                        if( is_string($this->actual) === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_STRING)->negatively()->build() );
                        }
                    }
                    else {
                        if( is_string($this->actual) === false ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_STRING)->build() );
                        }
                    }
                }
                else if( $this->testsTypeArray === true ) {
                    if( $this->negativeTest === true ) {
                        if( is_array($this->actual) === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_ARRAY)->negatively()->build() );
                        }
                    }
                    else {
                        if( is_array($this->actual) === false ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_ARRAY)->build() );
                        }
                    }
                }
                else if( $this->testsTypeInteger === true ) {
                    if( $this->negativeTest === true ) {
                        if( is_int($this->actual) === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_INTEGER)->negatively()->build() );
                        }
                    }
                    else {
                        if( is_int($this->actual) === false ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_INTEGER)->build() );
                        }
                    }
                }
                else if( $this->testsTypeFloat === true ) {
                    if( $this->negativeTest === true ) {
                        if( is_float($this->actual) === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_FLOAT)->negatively()->build() );
                        }
                    }
                    else {
                        if( is_float($this->actual) === false ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_FLOAT)->build() );
                        }
                    }
                }
                else if( $this->testsTypeDouble === true ) {
                    if( $this->negativeTest === true ) {
                        if( is_double($this->actual) === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_DOUBLE)->negatively()->build() );
                        }
                    }
                    else {
                        if( is_double($this->actual) === false ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_DOUBLE)->build() );
                        }
                    }
                }
                else if( $this->testsTypeFunction === true ) {
                    if( $this->negativeTest === true ) {
                        if( $this->isAFunction === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_FUNCTION)->negatively()->build() );
                        }
                    }
                    else {
                        if( $this->isAFunction === false ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_FUNCTION)->build() );
                        }
                    }
                }
            }
            else if( $this->testsException === true ) {
                if( $this->testsExceptionThrown === true ) {
                    if( $this->negativeTest === true ) {
                        if( $this->expected == $this->actual ) {
                            throw new TestFailedException( $message->checking(TestType::SAME_EXCEPTION)->negatively()->build() );
                        }
                    }
                    else {
                        if( $this->expected != $this->actual ) {
                            throw new TestFailedException( $message->checking(TestType::SAME_EXCEPTION)->build() );
                        }
                    }
                }
                else if( $this->testsExceptionMessage === true ) {
                    if( $this->negativeTest === true ) {
                        if( $this->expected == $this->actual ) {
                            throw new TestFailedException( $message->checking(TestType::SAME_EXCEPTION_MESSAGE)->negatively()->build() );
                        }
                    }
                    else {
                        if( $this->expected != $this->actual ) {
                            throw new TestFailedException( $message->checking(TestType::SAME_EXCEPTION_MESSAGE)->build() );
                        }
                    }
                }
            } 
        }
    }
?>