<?php
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