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
        protected $testsTypeBoolean;
        protected $testsTypeFunction;
        protected $testsTypeObject;
        protected $testsDisplaySomething;
        protected $testsFormatJson;
        protected $isAFunction;
        protected $isInJsonFormat;
        protected $expected;
        protected $actual;
        protected $negativeTest;
        protected $strictTest;
        protected $displayedMessage;

        public function __construct($actual) {
            if( is_callable($actual) === true ) {
                $this->isAFunction = true;

                try {
                    ob_start();

                    $this->actual = call_user_func($actual);

                    $this->displayedMessage = ob_get_clean();
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

        /**
         * Asserts that we are testing 
         * an equality.
         */
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

        /**
         * Asserts that we are testing an equality 
         * against a particular value.
         */
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

        public function inJsonFormat(): Expect {
            $this->testsFormatJson = true;
            
            json_decode((string) $this->actual);

            $this->isInJsonFormat = json_last_error() === JSON_ERROR_NONE;
            
            return $this;
        }

        public function anInteger(): Expect {
            $this->testsTypeInteger = true;
            
            return $this;
        }

        /**
         * Asserts that we expect the inverse of the test.
         */
        public function not(): Expect {
            $this->negativeTest = true;

            return $this;
        }

        /**
         * Asserts that we expect the test 
         * to be also type-tested (this will 
         * prevent from PHP to perform 
         * implicit cast when running the 
         * test).
         */
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

        public function toDisplay(string $message): Expect {
            $this->testsDisplaySomething = true;
            $this->expected = $message;
            $this->actual = $this->displayedMessage;

            return $this;
        }

        /**
         * @return Khalyomede\Style\Expect
         */
        public function aBoolean(): Expect {
            $this->testsTypeBoolean = true;

            return $this;
        }

        /**
         * @return Khalyomede\Style\Expect
         */
        public function anObject(): Expect {
            $this->testsTypeObject = true;

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
                    if( $this->testsFormatJson === true ) {
                        if( $this->negativeTest === true ) {
                            if( $this->isInJsonFormat === true ) {
                                throw new TestFailedException( $message->checking(TestType::FORMAT_JSON)->negatively()->build() );
                            }
                        }
                        else {
                            if( $this->isInJsonFormat === false ) {
                                throw new TestFailedException( $message->checking(TestType::FORMAT_JSON)->build() );
                            }
                        }
                    }
                    else {
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
                else if( $this->testsTypeBoolean === true ) {
                    if( $this->negativeTest === true ) {
                        if( is_bool($this->actual) === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_BOOLEAN)->negatively()->build() );
                        }
                    }
                    else {
                        if( is_bool($this->actual) === false ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_BOOLEAN)->build() );
                        }
                    }
                }
                else if( $this->testsTypeObject === true ) {
                    if( $this->negativeTest === true ) {
                        if( is_object($this->actual) === true ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_OBJECT)->negatively()->build() );
                        }
                    }
                    else {
                        if( is_object($this->actual) === false ) {
                            throw new TestFailedException( $message->checking(TestType::TYPE_OBJECT)->build() );
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
            else if( $this->testsDisplaySomething === true ) {
                if( $this->negativeTest === true ) {
                    if( $this->actual == $this->expected ) {
                        throw new TestFailedException( $message->checking(TestType::DISPLAYED_MESSAGE)->negatively()->build() );
                    }
                }
                else {
                    if( $this->actual != $this->expected ) {
                        throw new TestFailedException( $message->checking(TestType::DISPLAYED_MESSAGE)->build() );
                    }
                }
            }
        }
    }
?>