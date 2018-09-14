<?php
    use PHPUnit\Framework\TestCase;

    use function Khalyomede\Style\expect;
    use Khalyomede\Style\Expect;
    use Khalyomede\Exception\TestFailedException;

    class ExpectTest extends TestCase {
        // Equality - Integer        
        public function testEqualityBetweenIntegerAndInteger() {
            $value = 1;

            $this->assertInstanceOf(Expect::class, expect($value)->toBe()->equalTo($value) );
        }
        
        public function testEqualityBetweenIntegerAndFloat() {
            $this->assertInstanceOf(Expect::class, expect(1)->toBe()->equalTo(1.0));
        }

        public function testEqualityBetweenIntegerAndString() {
            $this->assertInstanceOf(Expect::class, expect(1)->toBe()->equalTo('1'));
        }

        public function testEqualityBetweenIntegerAndBool() {
            $this->assertInstanceOf(Expect::class, expect(1)->toBe()->equalTo(true));
        }

        // Equality - Float
        public function testEqualityBetweenFloatAndFloat() {
            $this->assertInstanceOf(Expect::class, expect(1.1)->toBe()->equalTo(1.1));
        }

        public function testEqualityBetweenFloatAndInteger() {
            $this->assertInstanceOf(Expect::class, expect(1.0)->toBe()->equalTo(1));
        }

        public function testEqualityBetweenFloatAndString() {
            $this->assertInstanceOf(Expect::class, expect(1.1)->toBe()->equalTo('1.1'));
        }

        public function testEqualityBetweenFloatAndBool() {
            $this->assertInstanceOf(Expect::class, expect(1.0)->toBe()->equalTo(true));
        }

        // Equality - string
        public function testEqualityBetweenStringAndInteger() {
            $this->assertInstanceOf(Expect::class, expect('1')->toBe()->equalTo(1));
        }

        public function testEqualityBetweenStringAndFloat() {
            $this->assertInstanceOf(Expect::class, expect('1.1')->toBe()->equalTo(1.1));
        }

        public function testEqualityBetweenStringAndString() {
            $value = '1';

            $this->assertInstanceOf(Expect::class, expect($value)->toBe()->equalTo($value));
        }

        public function testEqualityBetweenEmptyStringAndEmptyString() {
            $value = '';

            $this->assertInstanceOf(Expect::class, expect($value)->toBe()->equalTo($value));
        }

        public function testEqualityBetweenStringAndBool() {
            $this->assertInstanceOf(Expect::class, expect('1')->toBe()->equalTo(true));
        }

        // Equality - array
        public function testEqualityBetweenEmptyArrayAndEmptyArray() {
            $value = [];

            $this->assertInstanceOf(Expect::class, expect($value)->Tobe()->equalTo($value));
        }

        public function testEqualityBetweenArrayAndArray() {
            $value = range(1, 10);

            $this->assertInstanceOf(Expect::class, expect($value)->toBe()->equalTo($value));
        }

        // Equality - boolean
        public function testEqualityBetweenBoolAndBool() {
            $value = true;

            $this->assertInstanceOf(Expect::class, expect($value)->toBe()->equalTo($value));
        }

        public function testEqualityBetweenBoolAndInteger() {
            $this->assertInstanceOf(Expect::class, expect(true)->toBe()->equalTo(1));
        }

        public function testEqualityBetweenBoolAndFloat() {
            $this->assertInstanceOf(Expect::class, expect(true)->toBe()->equalTo(1.0));
        }

        public function testEqualityBetweenBoolAndString() {
            $this->assertInstanceOf(Expect::class, expect(true)->toBe()->equalTo('1'));
        }

        // Equality - object
        public function testEqualityBetweenObjectAndObject() {
            $value = new DateTime;

            $this->assertInstanceOf(Expect::class, expect($value)->toBe()->equalTo($value));
        }

        public function testEqualityBetweenEmptyObjectAndEmptyObject() {
            $value = new StdClass;

            $this->assertInstanceOf(Expect::class, expect($value)->toBe()->equalTo($value));
        }

        // Equality - null
        public function testEqualityBetweenNullAndNull() {
            $value = null;

            $this->assertInstanceOf(Expect::class, expect($value)->ToBe()->equalTo($value));
        }

        // Equality - function
        public function testEqualityBetweenFunctionReturningIntegerAndInteger() {
            $this->assertInstanceOf(Expect::class, expect(function() { return 1; })->toBe()->equalTo(1));
        }

        public function testEqualityBetweenFunctionReturningIntegerAndFloat() {
            $this->assertInstanceOf(Expect::class, expect(function() { return 1; })->toBe()->equalTo(1.0));
        }

        public function testEqualityBetweenFunctionReturningIntegerAndString() {
            $this->assertInstanceOf(Expect::class, expect(function() { return 1; })->toBe()->equalTo('1'));
        }

        // ---------------

        public function testFailingEqualityBetweenIntegerAndInteger() {
            $this->expectException(TestFailedException::class);

            expect(1)->ToBe()->equalTo(2);
        }
        
        public function testStrictEqualityBetweenInteger() {
            $this->assertInstanceOf(Expect::class, expect(1)->toBe()->strictly()->equalTo(1));
        }

        public function testInequalityBetweenIntegerAndInteger() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->equalTo(2));
        }
    }
?>