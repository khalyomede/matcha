<?php
    namespace Khalyomede\Style;

    use Khalyomede\Exception\TestFailedException;
    use Throwable;
    use InvalidArgumentException;

    /**
     * Expect test syntax style to use an eloquent way to describe the testing.
     * 
     * @see Khalyomede\Matcha
     * @example
     * require(__DIR__ . '/vendor/autoload.php');
     * 
     * // Khalyomede\Style\Expect is automatically loaded through its function.
     * 
     * describe('string', function() {
     *   describe('sprintf', function() {
     *     it('should return the correct string', function() {
     *       expect(sprintf('hello world'))->toBe()->equal('hello world'); // correct
     *     });
     * 
     *     it('should be equal to the formatted string', function() {
     *       expect(sprintf('hello %s'))->toBe()->equal('hello world'); // wrong
     *     });
     *   });
     * }); 
     */
    class Expect {
        const TYPE_STRING = 'string';
        const TYPE_FLOAT = 'float';
        const TYPE_INT = 'int';
        CONST TYPE_BOOL = 'bool';
        const TYPE_OBJECT = 'object';
        const TYPE_ARRAY = 'array';
        const ALLOWED_TYPES = [
            'string',
            'float',
            'int',
            'bool',
            'object',
            'array'
        ];

        /**
         * Stores the actual result to compare to.
         * 
         * @var mixed
         */
        protected $expected;

        /**
         * Stores if the comparison should be strict (if allowed by the comaprison type) or not.
         * 
         * @var bool
         */
        protected $strict_comparison;

        /**
         * Stores the fact that the following test is a negative comparison.
         * 
         * @var bool
         */
        protected $negative_comparison;

        /**
         * Constructor.
         * 
         * @param mixed $mixed  The statement to compare to the expected result.
         */
        public function __construct($mixed) {
            if( is_callable($mixed) === true ) {
                try {
                    call_user_func($mixed);

                    $this->expected = null;
                }
                catch( Throwable $exception ) {
                    $this->expected = $exception;
                }
            }
            else {
                $this->expected = $mixed;
            }

            $this->strict_comparison = false;
            $this->negative_comparison = false;
        }        

        /**
         * Function that only exists for grammar convenience.
         * 
         * @return Khalyomede\Style\Expect
         */
        public function toBe(): Expect {
            return $this;
        }

        /**
         * Throw an exception if the "actual" value is not equal to the given expected result.
         * The comparison can be modified via the property "strict_comparison" to strictly check the types.
         * 
         * @param mixed     $expected   The expected result to compare to.
         * @return Khalyomede\Style\Expect
         * @throws Khalyomede\Exception\TestFailedException When the test failed to compare the expected and the actual values.
         */
        public function equalTo($actual): Expect {
            if( $this->negative_comparison === true ) {
                if( $this->strict_comparison === true ) {
                    if( $this->expected === $actual ) {
                        throw (new TestFailedException(''))
                            ->actual($actual)
                            ->expected($this->expected)
                            ->testType(TestFailedException::TEST_EQUALITY)
                            ->negativeTest()
                            ->strictTest();
                    }
                }
                else {
                    if( $this->expected == $actual ) {
                        throw (new TestFailedException(''))
                            ->actual($actual)
                            ->expected($this->expected)
                            ->testType(TestFailedException::TEST_EQUALITY)
                            ->negativeTest();
                    }
                }
            }
            else {
                if( $this->strict_comparison === true ) {
                    if( $this->expected !== $actual ) {
                        throw (new TestFailedException(''))
                            ->actual($actual)
                            ->expected($this->expected)
                            ->testType(TestFailedException::TEST_EQUALITY)
                            ->strictTest();
                    }
                }
                else {
                    if( $this->expected != $actual ) {
                        throw (new TestFailedException(''))
                            ->actual($actual)
                            ->expected($this->expected)
                            ->testType(TestFailedException::TEST_EQUALITY);
                    }
                }
            }

            return $this;
        }

        /**
         * Settle a negativity in the final test.
         * 
         * @return Khalyomede\Style\That
         */
        public function not(): Expect {
            $this->negative_comparison = true;
            
            return $this;
        }

        /**
         * Throws an exception if the actual value is not of the given type.
         * 
         * @param string    $type   The type you want to check on.
         * @return Khalyomede\Style\Expect
         * @throws TestFailedException      If the actual value is not of the given type.
         * @throws InvalidArgumentException If the type is not one of the the static::ALLOWED_TYPES type.
         */
        public function a(string $type): Expect {
            switch( $type ) {
                case static::TYPE_STRING:
                    if( $this->negative_comparison === true ) {
                        if( is_string($this->expected) !== false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('string')
                                ->testType(TestFailedException::TEST_TYPE)
                                ->negativeTest();
                        }
                    }
                    else {
                        if( is_string($this->expected) === false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('string')
                                ->testType(TestFailedException::TEST_TYPE);
                        }
                    }

                    break;

                case static::TYPE_FLOAT:
                    if( $this->negative_comparison === true ) {
                        if( is_float($this->expected) !== true ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('float')
                                ->testType(TestFailedException::TEST_TYPE)
                                ->negativeTest();
                        } 
                    }
                    else {
                        if( is_float($this->expected) === false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('float')
                                ->testType(TestFailedException::TEST_TYPE);
                        } 
                    }

                    break;

                case static::TYPE_INT:
                    if( $this->negative_comparison === true ) {
                        if( is_int($this->expected) !== false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('int')
                                ->testType(TestFailedException::TEST_TYPE)
                                ->negativeTest();
                        }
                    }
                    else {
                        if( is_int($this->expected) === false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('int')
                                ->testType(TestFailedException::TEST_TYPE);
                        }
                    }

                    break;

                case static::TYPE_BOOL:
                    if( $this->negative_comparison === true ) {
                        if( is_bool($this->expected) !== false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('bool')
                                ->testType(TestFailedException::TEST_TYPE)
                                ->negativeTest();
                        }
                    }
                    else {
                        if( is_bool($this->expected) === false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('bool')
                                ->testType(TestFailedException::TEST_TYPE);
                        }
                    }

                    break;

                case static::TYPE_OBJECT:
                    if( $this->negative_comparison === true ) {
                        if( is_object($this->expected) !== false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('object')
                                ->testType(TestFailedException::TEST_TYPE)
                                ->negativeTest();
                        }
                    }
                    else {
                        if( is_object($this->expected) === false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('object')
                                ->testType(TestFailedException::TEST_TYPE);
                        }
                    }

                    break;

                case static::TYPE_ARRAY:
                    if( $this->negative_comparison === true ) {
                        if( is_array($this->expected) !== false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('array')
                                ->testType(TestFailedException::TEST_TYPE)
                                ->negativeTest();
                        }
                    }
                    else {
                        if( is_array($this->expected) === false ) {
                            throw (new TestFailedException(''))
                                ->expected($this->expected)
                                ->actual('array')
                                ->testType(TestFailedException::TEST_TYPE);
                        }
                    }

                    break;
                
                default:
                    throw new InvalidArgumentException(sprintf('the type check should be against one of the allowed types: %s', implode(static::ALLOWED_TYPES)));
            }
            
            return $this;
        }

        /**
         * Miror of the function "a" for grammar convenience.
         * 
         * @param string    $type   The type you want to check on.
         * @return Khalyomede\Style\Expect
         * @throws TestFailedException      If the actual value is not of the given type.
         * @throws InvalidArgumentException If the type is not one of the the static::ALLOWED_TYPES type. 
         */
        public function an(string $type) {
            return $this->a($type);
        }

        /**
         * Throws an exception if the actual value is not an instance of the given object.
         * 
         * @param string    $instance   The class name of the object to check its type against the actual value.
         * @return Khalyomede\Style\Expect
         */
        public function anInstanceOf(string $instance): Expect {
            if( $this->strict_comparison === true ) {
                if( $this->negative_comparison === true ) {
                    if( is_object($this->expected) && get_class($this->expected) === $instance ) {
                        throw (new TestFailedException(''))
                            ->expected($this->expected)
                            ->actual($instance)
                            ->testType(TestFailedException::TEST_INSTANCE)
                            ->negativeTest()
                            ->strictTest();
                    }
                }
                else {
                    if( is_object($this->expected) === false || get_class($this->expected) !== $instance ) {
                        throw (new TestFailedException(''))
                            ->expected($this->expected)
                            ->actual($instance)
                            ->testType(TestFailedException::TEST_INSTANCE)
                            ->strictTest();
                    }
                }
            }
            else {
                if( $this->negative_comparison === true ) {
                    if( $this->expected instanceof $instance === true ) {
                        throw (new TestFailedException(''))
                            ->expected($this->expected)
                            ->actual($instance)
                            ->testType(TestFailedException::TEST_INSTANCE)
                            ->negativeTest();
                    }
                }
                else {
                    if( $this->expected instanceof $instance === false ) {
                        throw (new TestFailedException(''))
                            ->expected($this->expected)
                            ->actual($instance)
                            ->testType(TestFailedException::TEST_INSTANCE);
                    }
                }
            }

            return $this;
        }

        /**
         * Throws an exception if the expected statement do not throw an instance of the given exception.
         * 
         * @param string $exception  The name of the instance of the exception to check on.
         * @return Khalyomede\Style\Expect
         */
        public function toThrow(string $instance): Expect {
            if( $this->strict_comparison === true ) {
                if( $this->negative_comparison === true ) {
                    if( is_object($this->expected) === true && get_class($this->expected) === $instance ) {
                        throw (new TestFailedException(''))
                            ->expected($this->expected)
                            ->actual($instance)
                            ->testType(TestFailedException::TEST_EXCEPTION)
                            ->negativeTest()
                            ->strictTest();
                    }
                }
                else {
                    if( is_object($this->expected) === false || get_class($this->expected) !== $instance ) {
                        throw (new TestFailedException(''))
                            ->expected($this->expected)
                            ->actual($instance)
                            ->testType(TestFailedException::TEST_EXCEPTION)
                            ->strictTest();
                    }
                }
            }
            else {
                if( $this->negative_comparison === true ) {
                    if( $this->expected instanceof $instance === true ) {
                        throw (new TestFailedException(''))
                            ->expected($this->expected)
                            ->actual($instance)
                            ->testType(TestFailedException::TEST_EXCEPTION)
                            ->negativeTest();
                    }
                }
                else {
                    if( $this->expected instanceof $instance === false ) {
                        throw (new TestFailedException(''))
                            ->expected($this->expected)
                            ->actual($instance)
                            ->testType(TestFailedException::TEST_EXCEPTION);
                    }
                }
            }
            
            return $this;
        }

        /**
         * Settle the fact that the test is strict (which means we will usually use triple equal to check the type AND the value).
         * 
         * @return Khalyomede\Style\Expect
         */
        public function strictly(): Expect {
            $this->strict_comparison = true;
            
            return $this;
        }
    }
?>