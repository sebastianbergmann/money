<?php
/**
 * Money
 *
 * Copyright (c) 2012-2013, Sebastian Bergmann <sebastian@phpunit.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    Money
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2013 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.github.com/sebastianbergmann/money
 */
namespace SebastianBergmann\Money
{
    class MoneyTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @covers            SebastianBergmann\Money\Money::__construct
         * @expectedException SebastianBergmann\Money\InvalidArgumentException
         */
        public function testExceptionIsRaisedForInvalidConstructorArguments()
        {
            $m = new Money(NULL, new Currency('EUR'));
        }

        /**
         * @covers SebastianBergmann\Money\Money::__construct
         */
        public function testObjectCanBeConstructedForValidConstructorArguments()
        {
            $m = new Money(0, new Currency('EUR'));

            $this->assertInstanceOf('SebastianBergmann\\Money\\Money', $m);

            return $m;
        }

        /**
         * @covers  SebastianBergmann\Money\Money::getAmount
         * @depends testObjectCanBeConstructedForValidConstructorArguments
         */
        public function testAmountCanBeRetrieved(Money $m)
        {
            $this->assertEquals(0, $m->getAmount());
        }

        /**
         * @covers  SebastianBergmann\Money\Money::getCurrency
         * @depends testObjectCanBeConstructedForValidConstructorArguments
         */
        public function testCurrencyCanBeRetrieved(Money $m)
        {
            $this->assertEquals(new Currency('EUR'), $m->getCurrency());
        }

        /**
         * @covers SebastianBergmann\Money\Money::add
         */
        public function testAnotherMoneyWithSameCurrencyObjectCanBeAdded()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = new Money(2, new Currency('EUR'));
            $c = $a->add($b);

            $this->assertEquals(1, $a->getAmount());
            $this->assertEquals(2, $b->getAmount());
            $this->assertEquals(3, $c->getAmount());
        }

        /**
         * @covers            SebastianBergmann\Money\Money::add
         * @expectedException SebastianBergmann\Money\CurrencyMismatchException
         */
        public function testExceptionIsRaisedWhenMoneyObjectWithDifferentCurrencyIsAdded()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = new Money(2, new Currency('USD'));

            $a->add($b);
        }

        /**
         * @covers SebastianBergmann\Money\Money::subtract
         */
        public function testAnotherMoneyObjectWithSameCurrencyCanBeSubtracted()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = new Money(2, new Currency('EUR'));
            $c = $b->subtract($a);

            $this->assertEquals(1, $a->getAmount());
            $this->assertEquals(2, $b->getAmount());
            $this->assertEquals(1, $c->getAmount());
        }

        /**
         * @covers            SebastianBergmann\Money\Money::subtract
         * @expectedException SebastianBergmann\Money\CurrencyMismatchException
         */
        public function testExceptionIsRaisedWhenMoneyObjectWithDifferentCurrencyIsSubtracted()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = new Money(2, new Currency('USD'));

            $b->subtract($a);
        }

        /**
         * @covers SebastianBergmann\Money\Money::negate
         */
        public function testCanBeNegated()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = $a->negate();

            $this->assertEquals(1, $a->getAmount());
            $this->assertEquals(-1, $b->getAmount());
        }

        /**
         * @covers SebastianBergmann\Money\Money::multiply
         */
        public function testCanBeMultipliedByAFactor()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = $a->multiply(2);

            $this->assertEquals(1, $a->getAmount());
            $this->assertEquals(2, $b->getAmount());
        }

        /**
         * @covers SebastianBergmann\Money\Money::allocateToTargets
         */
        public function testCanBeAllocatedToNumberOfTargets()
        {
            $a = new Money(99, new Currency('EUR'));
            $r = $a->allocateToTargets(10);

            $this->assertEquals(
              array(
                new Money(10, new Currency('EUR')),
                new Money(10, new Currency('EUR')),
                new Money(10, new Currency('EUR')),
                new Money(10, new Currency('EUR')),
                new Money(10, new Currency('EUR')),
                new Money(10, new Currency('EUR')),
                new Money(10, new Currency('EUR')),
                new Money(10, new Currency('EUR')),
                new Money(10, new Currency('EUR')),
                new Money(9,  new Currency('EUR'))
              ),
              $r
            );
        }

        /**
         * @covers SebastianBergmann\Money\Money::allocateByRatios
         */
        public function testCanBeAllocatedByRatios()
        {
            $a = new Money(5, new Currency('EUR'));
            $r = $a->allocateByRatios(array(3, 7));

            $this->assertEquals(
              array(
                new Money(2, new Currency('EUR')),
                new Money(3, new Currency('EUR'))
              ),
              $r
            );
        }

        /**
         * @covers SebastianBergmann\Money\Money::compareTo
         */
        public function testCanBeComparedToAnotherMoneyObjectWithSameCurrency()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = new Money(2, new Currency('EUR'));

            $this->assertEquals(-1, $a->compareTo($b));
            $this->assertEquals(1, $b->compareTo($a));
            $this->assertEquals(0, $a->compareTo($a));
        }

        /**
         * @covers  SebastianBergmann\Money\Money::greaterThan
         * @depends testCanBeComparedToAnotherMoneyObjectWithSameCurrency
         */
        public function testCanBeComparedToAnotherMoneyObjectWithSameCurrency2()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = new Money(2, new Currency('EUR'));

            $this->assertFalse($a->greaterThan($b));
            $this->assertTrue($b->greaterThan($a));
        }

        /**
         * @covers  SebastianBergmann\Money\Money::lessThan
         * @depends testCanBeComparedToAnotherMoneyObjectWithSameCurrency
         */
        public function testCanBeComparedToAnotherMoneyObjectWithSameCurrency3()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = new Money(2, new Currency('EUR'));

            $this->assertFalse($b->lessThan($a));
            $this->assertTrue($a->lessThan($b));
        }

        /**
         * @covers            SebastianBergmann\Money\Money::compareTo
         * @expectedException SebastianBergmann\Money\CurrencyMismatchException
         */
        public function testExceptionIsRaisedWhenComparedToMoneyObjectWithDifferentCurrency()
        {
            $a = new Money(1, new Currency('EUR'));
            $b = new Money(2, new Currency('USD'));

            $a->compareTo($b);
        }
    }
}
