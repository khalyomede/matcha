<?php
    use PHPUnit\Framework\TestCase;

    use function Khalyomede\Style\expect;
    use Khalyomede\Style\Expect;
    use Khalyomede\Exception\TestFailedException;

    class ExpectTest extends TestCase {
        // Equality against a value
        public function testEquality() {
            $this->assertInstanceOf(Expect::class, expect(1)->toBe()->equalTo(1));
        }

        public function testFailingEquality() {
            $this->expectException(TestFailedException::class);

            expect(1)->ToBe()->equalTo(2);
        }
        
        public function testStrictEquality() {
            $this->assertInstanceOf(Expect::class, expect(1)->toBe()->strictly()->equalTo(1));
        }

        public function testFailingStrictEquality() {
            $this->expectException(TestFailedException::class);

            expect(1)->toBe()->strictly()->equalTo('1');
        }

        public function testInequality() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->equalTo(2));
        }

        public function testFailingInequality() {
            $this->expectException(TestFailedException::class);

            expect(1)->not()->toBe()->equalTo(1);
        }

        public function testStrictInequality() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->strictly()->equalTo('1'));
        }

        public function testFailingStrictInequality() {
            $this->expectException(TestFailedException::class);

            expect(1)->not()->toBe()->strictly()->equalTo(1);
        }

        // Instance of
        public function testInstanceOf() {
            $this->assertInstanceOf(Expect::class, expect(new Exception)->toBe()->anInstanceOf(Throwable::class));
        }

        public function testFailingInstanceOf() {
            $this->expectException(TestFailedException::class);

            expect(new Exception)->toBe()->anInstanceOf(InvalidArgumentException::class);
        }

        public function testNonInstanceOf() {
            $this->assertInstanceOf(Expect::class, expect(new Exception)->not()->toBe()->anInstanceOf(InvalidArgumentException::class));
        }

        public function testFailingNonInstanceOf() {
            $this->expectException(TestFailedException::class);

            expect(new InvalidArgumentException)->not()->toBe()->anInstanceOf(Exception::class);
        }

        // Equality against null
        public function testNullity() {
            $this->assertInstanceOf(Expect::class, expect(null)->toBe()->null());
        }

        public function testFailingNullity() {
            $this->expectException(TestFailedException::class);

            expect('')->toBe()->null();
        }

        public function testNonNullity() {
            $this->assertInstanceOf(Expect::class, expect('')->not()->ToBe()->null());
        }

        public function testFailingNonNullity() {
            $this->expectException(TestFailedException::class);

            expect(null)->not()->toBe()->null();
        }

        // Resource
        public function testResourceEquality() {
            $this->assertInstanceOf(Expect::class, expect(fopen('./test/ExpectTest.php', 'r'))->toBe()->aResource());
        }

        public function testFailingResourceEquality() {
            $this->expectException(TestFailedException::class);

            expect(1)->toBe()->aResource();
        }

        public function testNonResourceEquality() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->aResource());
        }

        public function testFailingNonResourceEquality() {
            $this->expectException(TestFailedException::class);

            expect(fopen('./test/ExpectTest.php', 'r'))->not()->toBe()->aResource();
        }

        // Equality against true
        public function testTruthy() {
            $this->assertInstanceOf(Expect::class, expect(true)->toBe()->true());
        }

        public function testFailingTruthy() {
            $this->expectException(TestFailedException::class);

            expect(false)->toBe()->true();
        }

        public function testStrictTruthy() {
            $this->assertInstanceOf(Expect::class, expect(true)->toBe()->strictly()->true());
        }

        public function testFailingStrictTruthy() {
            $this->expectException(TestFailedException::class);

            expect(1)->toBe()->strictly()->true();
        }

        public function testNonTruthy() {
            $this->assertInstanceOf(Expect::class, expect(false)->not()->toBe()->true());
        }

        public function testFailingNonTruhty() {
            $this->expectException(TestFailedException::class);

            expect(true)->not()->ToBe()->true();
        }

        public function testStrictNonTruthy() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->strictly()->true());
        }

        public function testFailingStrictNonTruthy() {
            $this->expectException(TestFailedException::class);
            
            expect(true)->not()->ToBe()->strictly()->true();
        }

        // Equality against false
        public function testFalsy() {
            $this->assertInstanceOf(Expect::class, expect(false)->toBe()->false());
        }

        public function testFailingFalsy() {
            $this->expectException(TestFailedException::class);

            expect(true)->toBe()->false();
        }

        public function testNonFalsy() {
            $this->assertInstanceOf(Expect::class, expect(true)->not()->toBe()->false());
        }

        public function testFailingNonFalsy() {
            $this->expectException(TestFailedException::class);

            expect(false)->not()->toBe()->false();
        }

        public function testStrictFalsy() {
            $this->assertInstanceOf(Expect::class, expect(false)->toBe()->strictly()->false());
        }

        public function testFailingStrictFalsy() {
            $this->expectException(TestFailedException::class);

            expect(0)->toBe()->strictly()->false();
        }

        public function testStrictNonFalsy() {
            $this->assertInstanceOf(Expect::class, expect(0)->not()->toBe()->strictly()->false());
        }

        public function testFailingStrictNonFalsy() {
            $this->expectException(TestFailedException::class);

            expect(false)->not()->toBe()->strictly()->false();
        }

        // Being a string
        public function testTypeString() {
            $this->assertInstanceOf(Expect::class, expect('')->toBe()->aString());
        }

        public function testFailingTypeString() {
            $this->expectException(TestFailedException::class);

            expect(1)->toBe()->aString();
        }

        public function testNonString() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->aString());
        }

        public function testFailingNonString() {
            $this->expectException(TestFailedException::class);

            expect('')->not()->toBe()->aString();
        }

        // Being an array
        public function testTypeArray() {
            $this->assertInstanceOf(Expect::class, expect([])->toBe()->anArray());
        }

        public function testFailingTypeArray() {
            $this->expectException(TestFailedException::class);

            expect(1)->toBe()->anArray();
        }

        public function testNonTypeArray() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->anArray());
        }

        public function testFalingNonTypeArray() {
            $this->expectException(TestFailedException::class);

            expect([])->not()->toBe()->anArray();
        }        

        // Being an integer
        public function testTypeInteger() {
            $this->assertInstanceOf(Expect::class, expect(1)->toBe()->anInteger());
        }

        public function testFailingTypeInteger() {
            $this->expectException(TestFailedException::class);

            expect('1')->toBe()->anInteger();
        }

        public function testNonTypeInteger() {
            $this->assertInstanceOf(Expect::class, expect('1')->not()->toBe()->anInteger());
        }

        public function testFailingNonTypeInteger() {
            $this->expectException(TestFailedException::class);

            expect(1)->not()->toBe()->anInteger();
        }

        // Being a float
        public function testTypeFloat() {
            $this->assertInstanceOf(Expect::class, expect(1.1)->toBe()->aFloat());
        }

        public function testFailingTypeFloat() {
            $this->expectException(TestFailedException::class);

            expect(1)->toBe()->aFloat();
        }

        public function testNonTypeFloat() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->aFloat());
        }

        public function testFailingNonTypeFloat() {
            $this->expectException(TestFailedException::class);

            expect(1.1)->not()->ToBe()->aFloat();
        }

        // Being a double
        public function testTypeDouble() {
            $this->assertInstanceOf(Expect::class, expect(1.1)->toBe()->aDouble());
        }

        public function testFailingTypeDouble() {
            $this->expectException(TestFailedException::class);

            expect(1)->toBe()->aDouble();
        }

        public function testNotTypeDouble() {
            $this->assertInstanceOf(Expect::class, expect(1)->not()->toBe()->aDouble());
        }

        public function testFailingNotTypeDouble() {
            $this->expectException(TestFailedException::class);

            expect(1.1)->not()->toBe()->aDouble();
        }
    }
?>