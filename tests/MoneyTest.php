<?php
namespace SebastianBergmann\Money\Tests
{
    class MoneyTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @covers            SebastianBergmann\Money\Money::__construct
         * @expectedException SebastianBergmann\Money\InvalidArgumentException
         */
        public function testExceptionIsRaisedForInvalidConstructorArgument()
        {
            $m = new Money(NULL);
        }

        /**
         * @covers SebastianBergmann\Money\Money::__construct
         */
        public function testObjectCanBeConstructedForValidConstructorArgument()
        {
            $m = new Money(0);

            $this->assertInstanceOf('SebastianBergmann\\Money\\Money', $m);

            return $m;
        }

        /**
         * @covers  SebastianBergmann\Money\Money::getAmount
         * @depends testObjectCanBeConstructedForValidConstructorArgument
         */
        public function testAmountCanBeRetrieved(Money $m)
        {
            $this->assertEquals(0, $m->getAmount());
        }

        /**
         * @covers SebastianBergmann\Money\Money::add
         */
        public function testAnotherMoneyObjectCanBeAdded()
        {
            $a = new Money(1);
            $b = new Money(2);
            $c = $a->add($b);

            $this->assertEquals(1, $a->getAmount());
            $this->assertEquals(2, $b->getAmount());
            $this->assertEquals(3, $c->getAmount());
        }

        /**
         * @covers SebastianBergmann\Money\Money::subtract
         */
        public function testAnotherMoneyObjectCanBeSubtracted()
        {
            $a = new Money(1);
            $b = new Money(2);
            $c = $b->subtract($a);

            $this->assertEquals(1, $a->getAmount());
            $this->assertEquals(2, $b->getAmount());
            $this->assertEquals(1, $c->getAmount());
        }

        /**
         * @covers SebastianBergmann\Money\Money::negate
         */
        public function testCanBeNegated()
        {
            $a = new Money(1);
            $b = $a->negate();

            $this->assertEquals(1, $a->getAmount());
            $this->assertEquals(-1, $b->getAmount());
        }

        /**
         * @covers SebastianBergmann\Money\Money::multiply
         */
        public function testCanBeMultipliedByAFactor()
        {
            $a = new Money(1);
            $b = $a->multiply(2);

            $this->assertEquals(1, $a->getAmount());
            $this->assertEquals(2, $b->getAmount());
        }

        /**
         * @covers SebastianBergmann\Money\Money::divide
         */
        public function testCanBeDividedByADenominator()
        {
            $a = new Money(99);
            $b = $a->divide(10);

            $this->assertEquals(
              array(
                new Money(10),
                new Money(10),
                new Money(10),
                new Money(10),
                new Money(10),
                new Money(10),
                new Money(10),
                new Money(10),
                new Money(10),
                new Money(9)
              ),
              $b
            );
        }

        /**
         * @covers SebastianBergmann\Money\Money::compareTo
         */
        public function testCanBeComparedToAnotherMoneyObject()
        {
            $a = new Money(1);
            $b = new Money(2);

            $this->assertEquals(-1, $a->compareTo($b));
            $this->assertEquals( 1, $b->compareTo($a));
            $this->assertEquals(0, $a->compareTo($a));
        }

        /**
         * @covers  SebastianBergmann\Money\Money::greaterThan
         * @depends testCanBeComparedToAnotherMoneyObject
         */
        public function testCanBeComparedToAnotherMoneyObject2()
        {
            $a = new Money(1);
            $b = new Money(2);

            $this->assertFalse($a->greaterThan($b));
            $this->assertTrue($b->greaterThan($a));
        }

        /**
         * @covers  SebastianBergmann\Money\Money::lessThan
         * @depends testCanBeComparedToAnotherMoneyObject
         */
        public function testCanBeComparedToAnotherMoneyObject3()
        {
            $a = new Money(1);
            $b = new Money(2);

            $this->assertFalse($b->lessThan($a));
            $this->assertTrue($a->lessThan($b));
        }
    }
}
