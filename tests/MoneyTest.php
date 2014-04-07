<?php
/**
 * Money
 *
 * Copyright (c) 2012-2014, Sebastian Bergmann <sebastian@phpunit.de>.
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
 * @copyright  2012-2014 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.github.com/sebastianbergmann/money
 */
namespace SebastianBergmann\Money;

class MoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers            \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\InvalidArgumentException
     */
    public function testExceptionIsRaisedForInvalidConstructorArguments()
    {
        new Money(null, new Currency('EUR'));
    }

    /**
     * @covers \SebastianBergmann\Money\Money::__construct
     * @uses   \SebastianBergmann\Money\Currency
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $m = new Money(0, new Currency('EUR'));

        $this->assertInstanceOf('SebastianBergmann\\Money\\Money', $m);

        return $m;
    }

    /**
     * @covers  \SebastianBergmann\Money\Money::getAmount
     * @depends testObjectCanBeConstructedForValidConstructorArguments
     */
    public function testAmountCanBeRetrieved(Money $m)
    {
        $this->assertEquals(0, $m->getAmount());
    }

    /**
     * @covers  \SebastianBergmann\Money\Money::getCurrency
     * @uses    \SebastianBergmann\Money\Currency
     * @depends testObjectCanBeConstructedForValidConstructorArguments
     */
    public function testCurrencyCanBeRetrieved(Money $m)
    {
        $this->assertEquals(new Currency('EUR'), $m->getCurrency());
    }

    /**
     * @covers \SebastianBergmann\Money\Money::add
     * @covers \SebastianBergmann\Money\Money::newMoney
     * @covers \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses   \SebastianBergmann\Money\Money::__construct
     * @uses   \SebastianBergmann\Money\Money::getAmount
     * @uses   \SebastianBergmann\Money\Money::getCurrency
     * @uses   \SebastianBergmann\Money\Money::assertIsInteger
     * @uses   \SebastianBergmann\Money\Currency
     */
    public function testAnotherMoneyObjectWithSameCurrencyCanBeAdded()
    {
        $a = new Money(1, new Currency('EUR'));
        $b = new Money(2, new Currency('EUR'));
        $c = $a->add($b);

        $this->assertEquals(1, $a->getAmount());
        $this->assertEquals(2, $b->getAmount());
        $this->assertEquals(3, $c->getAmount());
    }

    /**
     * @covers            \SebastianBergmann\Money\Money::add
     * @covers            \SebastianBergmann\Money\Money::newMoney
     * @covers            \SebastianBergmann\Money\Money::assertSameCurrency
     * @covers            \SebastianBergmann\Money\Money::assertIsInteger
     * @uses              \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Money::getAmount
     * @uses              \SebastianBergmann\Money\Money::getCurrency
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\OverflowException
     */
    public function testExceptionIsThrownForOverflowingAddition()
    {
        $a = new Money(PHP_INT_MAX, new Currency('EUR'));
        $b = new Money(2, new Currency('EUR'));
        $a->add($b);
    }

    /**
     * @uses              \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Money::multiply
     * @uses              \SebastianBergmann\Money\Money::castToInt
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\OverflowException
     */
    public function testExceptionIsRaisedForIntegerOverflow()
    {
        $a = new Money(PHP_INT_MAX, new Currency('EUR'));
        $a->multiply(2);
    }

    /**
     * @covers            \SebastianBergmann\Money\Money::add
     * @covers            \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses              \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Money::getAmount
     * @uses              \SebastianBergmann\Money\Money::getCurrency
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function testExceptionIsRaisedWhenMoneyObjectWithDifferentCurrencyIsAdded()
    {
        $a = new Money(1, new Currency('EUR'));
        $b = new Money(2, new Currency('USD'));

        $a->add($b);
    }

    /**
     * @covers \SebastianBergmann\Money\Money::subtract
     * @covers \SebastianBergmann\Money\Money::newMoney
     * @covers \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses   \SebastianBergmann\Money\Money::__construct
     * @uses   \SebastianBergmann\Money\Money::getAmount
     * @uses   \SebastianBergmann\Money\Money::getCurrency
     * @uses   \SebastianBergmann\Money\Money::assertIsInteger
     * @uses   \SebastianBergmann\Money\Currency
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
     * @covers            \SebastianBergmann\Money\Money::subtract
     * @covers            \SebastianBergmann\Money\Money::newMoney
     * @covers            \SebastianBergmann\Money\Money::assertSameCurrency
     * @covers            \SebastianBergmann\Money\Money::assertIsInteger
     * @uses              \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Money::getAmount
     * @uses              \SebastianBergmann\Money\Money::getCurrency
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\OverflowException
     */
    public function testExceptionIsThrownForOverflowingSubtraction()
    {
        $a = new Money(-PHP_INT_MAX, new Currency('EUR'));
        $b = new Money(2, new Currency('EUR'));
        $a->subtract($b);
    }

    /**
     * @covers            \SebastianBergmann\Money\Money::subtract
     * @covers            \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses              \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Money::getAmount
     * @uses              \SebastianBergmann\Money\Money::getCurrency
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function testExceptionIsRaisedWhenMoneyObjectWithDifferentCurrencyIsSubtracted()
    {
        $a = new Money(1, new Currency('EUR'));
        $b = new Money(2, new Currency('USD'));

        $b->subtract($a);
    }

    /**
     * @covers \SebastianBergmann\Money\Money::negate
     * @covers \SebastianBergmann\Money\Money::newMoney
     * @uses   \SebastianBergmann\Money\Money::__construct
     * @uses   \SebastianBergmann\Money\Money::getAmount
     * @uses   \SebastianBergmann\Money\Currency
     */
    public function testCanBeNegated()
    {
        $a = new Money(1, new Currency('EUR'));
        $b = $a->negate();

        $this->assertEquals(1, $a->getAmount());
        $this->assertEquals(-1, $b->getAmount());
    }

    /**
     * @covers \SebastianBergmann\Money\Money::multiply
     * @covers \SebastianBergmann\Money\Money::newMoney
     * @covers \SebastianBergmann\Money\Money::castToInt
     * @uses   \SebastianBergmann\Money\Money::__construct
     * @uses   \SebastianBergmann\Money\Money::getAmount
     * @uses   \SebastianBergmann\Money\Money::assertInsideIntegerBounds
     * @uses   \SebastianBergmann\Money\Currency
     */
    public function testCanBeMultipliedByAFactor()
    {
        $a = new Money(1, new Currency('EUR'));
        $b = $a->multiply(2);

        $this->assertEquals(1, $a->getAmount());
        $this->assertEquals(2, $b->getAmount());
    }

    /**
     * @covers            \SebastianBergmann\Money\Money::multiply
     * @uses              \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\InvalidArgumentException
     */
    public function testExceptionIsRaisedWhenMultipliedUsingInvalidRoundingMode()
    {
        $a = new Money(1, new Currency('EUR'));
        $a->multiply(2, null);
    }

    /**
     * @covers \SebastianBergmann\Money\Money::allocateToTargets
     * @covers \SebastianBergmann\Money\Money::newMoney
     * @uses   \SebastianBergmann\Money\Money::__construct
     * @uses   \SebastianBergmann\Money\Money::getAmount
     * @uses   \SebastianBergmann\Money\Currency
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
                new Money(9, new Currency('EUR'))
            ),
            $r
        );
    }

    /**
     * @covers            \SebastianBergmann\Money\Money::allocateToTargets
     * @uses              \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\InvalidArgumentException
     */
    public function testExceptionIsRaisedWhenTryingToAllocateToInvalidNumberOfTargets()
    {
        $a = new Money(0, new Currency('EUR'));
        $a->allocateToTargets(null);
    }

    /**
     * @covers \SebastianBergmann\Money\Money::allocateByRatios
     * @covers \SebastianBergmann\Money\Money::newMoney
     * @covers \SebastianBergmann\Money\Money::castToInt
     * @uses   \SebastianBergmann\Money\Money::__construct
     * @uses   \SebastianBergmann\Money\Money::getAmount
     * @uses   \SebastianBergmann\Money\Money::assertInsideIntegerBounds
     * @uses   \SebastianBergmann\Money\Currency
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
     * @covers \SebastianBergmann\Money\Money::compareTo
     * @covers \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses   \SebastianBergmann\Money\Money::__construct
     * @uses   \SebastianBergmann\Money\Money::getAmount
     * @uses   \SebastianBergmann\Money\Money::getCurrency
     * @uses   \SebastianBergmann\Money\Currency
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
     * @covers  \SebastianBergmann\Money\Money::greaterThan
     * @covers  \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses    \SebastianBergmann\Money\Money::__construct
     * @uses    \SebastianBergmann\Money\Money::compareTo
     * @uses    \SebastianBergmann\Money\Money::getAmount
     * @uses    \SebastianBergmann\Money\Money::getCurrency
     * @uses    \SebastianBergmann\Money\Currency
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
     * @covers  \SebastianBergmann\Money\Money::lessThan
     * @covers  \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses    \SebastianBergmann\Money\Money::__construct
     * @uses    \SebastianBergmann\Money\Money::compareTo
     * @uses    \SebastianBergmann\Money\Money::getAmount
     * @uses    \SebastianBergmann\Money\Money::getCurrency
     * @uses    \SebastianBergmann\Money\Currency
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
     * @covers  \SebastianBergmann\Money\Money::equals
     * @covers  \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses    \SebastianBergmann\Money\Money::__construct
     * @uses    \SebastianBergmann\Money\Money::compareTo
     * @uses    \SebastianBergmann\Money\Money::getAmount
     * @uses    \SebastianBergmann\Money\Money::getCurrency
     * @uses    \SebastianBergmann\Money\Currency
     * @depends testCanBeComparedToAnotherMoneyObjectWithSameCurrency
     */
    public function testCanBeComparedToAnotherMoneyObjectWithSameCurrency4()
    {
        $a = new Money(1, new Currency('EUR'));
        $b = new Money(1, new Currency('EUR'));

        $this->assertEquals(0, $a->compareTo($b));
        $this->assertEquals(0, $b->compareTo($a));
        $this->assertTrue($a->equals($b));
        $this->assertTrue($b->equals($a));
    }

    /**
     * @covers  \SebastianBergmann\Money\Money::greaterThanOrEqual
     * @covers  \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses    \SebastianBergmann\Money\Money::__construct
     * @uses    \SebastianBergmann\Money\Money::greaterThan
     * @uses    \SebastianBergmann\Money\Money::equals
     * @uses    \SebastianBergmann\Money\Money::compareTo
     * @uses    \SebastianBergmann\Money\Money::getAmount
     * @uses    \SebastianBergmann\Money\Money::getCurrency
     * @uses    \SebastianBergmann\Money\Currency
     * @depends testCanBeComparedToAnotherMoneyObjectWithSameCurrency
     */
    public function testCanBeComparedToAnotherMoneyObjectWithSameCurrency5()
    {
        $a = new Money(2, new Currency('EUR'));
        $b = new Money(2, new Currency('EUR'));
        $c = new Money(1, new Currency('EUR'));

        $this->assertTrue($a->greaterThanOrEqual($a));
        $this->assertTrue($a->greaterThanOrEqual($b));
        $this->assertTrue($a->greaterThanOrEqual($c));
        $this->assertFalse($c->greaterThanOrEqual($a));
    }

    /**
     * @covers  \SebastianBergmann\Money\Money::lessThanOrEqual
     * @covers  \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses    \SebastianBergmann\Money\Money::__construct
     * @uses    \SebastianBergmann\Money\Money::lessThan
     * @uses    \SebastianBergmann\Money\Money::equals
     * @uses    \SebastianBergmann\Money\Money::compareTo
     * @uses    \SebastianBergmann\Money\Money::getAmount
     * @uses    \SebastianBergmann\Money\Money::getCurrency
     * @uses    \SebastianBergmann\Money\Currency
     * @depends testCanBeComparedToAnotherMoneyObjectWithSameCurrency
     */
    public function testCanBeComparedToAnotherMoneyObjectWithSameCurrency6()
    {
        $a = new Money(1, new Currency('EUR'));
        $b = new Money(1, new Currency('EUR'));
        $c = new Money(2, new Currency('EUR'));

        $this->assertTrue($a->lessThanOrEqual($a));
        $this->assertTrue($a->lessThanOrEqual($b));
        $this->assertTrue($a->lessThanOrEqual($c));
        $this->assertFalse($c->lessThanOrEqual($a));
    }

    /**
     * @covers            \SebastianBergmann\Money\Money::compareTo
     * @covers            \SebastianBergmann\Money\Money::assertSameCurrency
     * @uses              \SebastianBergmann\Money\Money::__construct
     * @uses              \SebastianBergmann\Money\Money::getCurrency
     * @uses              \SebastianBergmann\Money\Currency
     * @expectedException \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function testExceptionIsRaisedWhenComparedToMoneyObjectWithDifferentCurrency()
    {
        $a = new Money(1, new Currency('EUR'));
        $b = new Money(2, new Currency('USD'));

        $a->compareTo($b);
    }
}
