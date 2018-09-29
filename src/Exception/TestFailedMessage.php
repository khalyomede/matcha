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

    namespace Khalyomede\Exception;

    use Khalyomede\TestType;

    class TestFailedMessage {
        protected $expected;
        protected $actual;
        protected $testType;
        protected $negativeTest;
        protected $strictTest;

        public function __construct() {
            $this->negativeTest = false;
        }

        public function expected($value): TestFailedMessage {
            $this->expected = $value;

            return $this;
        }

        public function actual($value): TestFailedMessage {
            $this->actual = $value;

            return $this;
        }

        public function checking(int $type): TestFailedMessage {
            $this->testType = $type;

            return $this;
        }

        public function negatively(): TestFailedMessage {
            $this->negativeTest = true;

            return $this;
        }

        public function strictly(): TestFailedMessage {
            $this->strictTest = true;

            return $this;
        }

        public function build(): string {
            $expected = static::format($this->expected);
            $actual = static::format($this->actual);
            $message = "";

            if( $this->testType === TestType::SAME_VALUE ) {
                $message = "expected $actual ";
                
                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                $message .= "equal to $expected";
            }
            else if( $this->testType === TestType::SAME_EXCEPTION ) {
                $message = "expected exception $actual ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }
                
                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be $expected";
            }
            else if( $this->testType === TestType::SAME_EXCEPTION_MESSAGE ) {
                $message = "expected exception message $actual ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be $expected";
            }
            else if( $this->testType === TestType::INSTANCE_OF ) {
                $message = "expected $actual ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be an instance of $expected";
            }
            else if( $this->testType === TestType::NULLITY ) {
                $message = "expected $actual ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be $expected";
            }
            else if( $this->testType === TestType::TYPE_RESOURCE ) {
                $message = "expected $actual ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be a resource";
            }
            else if( $this->testType === TestType::VALUE_TRUE ) {
                $message = "expected $actual ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be $expected";
            }
            else if( $this->testType === TestType::TYPE_STRING ) {
                $message = "expected $actual ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be a string";
            }
            else if( $this->testType === TestType::TYPE_ARRAY ) {
                $message = "expected $actual ";
                
                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be an array";
            }
            else if( $this->testType === TestType::VALUE_FALSE ) {
                $message = "expected $actual ";

                if( $this->strictTest === true ) {
                    $message .= "strictly ";
                }

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be false";
            }
            else if( $this->testType === TestType::TYPE_INTEGER ) {
                $message = "expected $actual ";

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be an integer";
            }
            else if( $this->testType === TestType::TYPE_FLOAT ) {
                $message = "expected $actual ";

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be a float";
            }
            else if( $this->testType === TestType::TYPE_DOUBLE ) {
                $message = "expected $actual ";

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be a double";
            }
            else if( $this->testType === TestType::TYPE_FUNCTION ) {
                $message = "expected $actual ";

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be a function";
            }
            else if( $this->testType === TestType::DISPLAYED_MESSAGE ) {
                $target = php_sapi_name() === 'cli' ? 'console' : 'web page';

                $message = "expected displayed message $actual ";

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message .= "to be $expected in $target";
            }
            else if( $this->testType === TestType::TYPE_BOOLEAN ) {
                $message = "expected $actual ";

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message = "to be a boolean";
            }
            else if( $this->testType === TestType::TYPE_OBJECT ) {
                $message = "expected $actual ";

                if( $this->negativeTest === true ) {
                    $message .= "not ";
                }

                $message = "to be an object";
            }
 
            return $message;
        }

        private static function format($variable): string {
            $string = $variable;

            if( is_callable($string) === true ) {
                $string = 'function';
            }
            else if( is_object($string) === true ) {
                $string = 'class ' . get_class($string);
            }
            else if( is_resource($string) === true ) {
                $string = 'resource';
            }
            else if( is_bool($string) === true ) {
                $string = 'bool(' . ($string ? 'true' : 'false') . ')';
            }
            else if( is_array($string) === true ) {
                $string = print_r($string, true);
            }
            else if( is_string($string) === true ) {
                $string = '"' . $string . '"';
            }
            else if( is_null($string) === true ) {
                $string = "null";
            }

            return $string;
        }
    }
?>