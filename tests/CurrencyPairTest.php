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
namespace SebastianBergmann\Money;

class CurrencyPairTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers            SebastianBergmann\Money\CurrencyPair::__construct
     * @expectedException SebastianBergmann\Money\InvalidArgumentException
     */
    public function testExceptionIsRaisedForInvalidConstructorArgument()
    {
        $c = new CurrencyPair(new Currency('EUR'), new Currency('USD'), NULL);
    }
    
    /**
     * @covers  SebastianBergmann\Money\CurrencyPair::__construct
     * @uses    SebastianBergmann\Money\Currency
     */
    public function testObjectCanBeConstructedForValidConstructorArgument()
    {
        $cp = new CurrencyPair(new Currency('EUR'), new Currency('USD'), 1.25);

        $this->assertInstanceOf('SebastianBergmann\\Money\\CurrencyPair', $cp);
        
        return $cp;
    }

    /**
     * @covers  SebastianBergmann\Money\CurrencyPair::convertToCounter
     * @uses    SebastianBergmann\Money\Money
     * @uses    SebastianBergmann\Money\Currency
     * @expectedException SebastianBergmann\Money\CurrencyMismatchException
     * @depends testObjectCanBeConstructedForValidConstructorArgument
     */
    public function testExceptionIdRaisedForInvalidCurrencyInConvertToCounter(CurrencyPair $cp)
    {
        $cp->convertToCounter(new Money(1000, new Currency('USD')));
    }

    /**
     * @covers  SebastianBergmann\Money\CurrencyPair::convertToCounter
     * @uses    SebastianBergmann\Money\Money
     * @uses    SebastianBergmann\Money\Currency
     * @depends testObjectCanBeConstructedForValidConstructorArgument
     */
    public function testConvertToCounter(CurrencyPair $cp)
    {
        $m = $cp->convertToCounter(new Money(1000, new Currency('EUR')));
        
        $this->assertInstanceOf('SebastianBergmann\\Money\\Money', $m);
        
        $this->assertEquals(1250, $m->getAmount());
    }

    /**
     * @covers  SebastianBergmann\Money\CurrencyPair::convertToBase
     * @uses    SebastianBergmann\Money\Money
     * @uses    SebastianBergmann\Money\Currency
     * @expectedException SebastianBergmann\Money\CurrencyMismatchException
     * @depends testObjectCanBeConstructedForValidConstructorArgument
     */
    public function testExceptionIdRaisedForInvalidCurrencyInConvertToBase(CurrencyPair $cp)
    {
        $cp->convertToBase(new Money(1000, new Currency('EUR')));
    }

    /**
     * @covers  SebastianBergmann\Money\CurrencyPair::convertToBase
     * @uses    SebastianBergmann\Money\Money
     * @uses    SebastianBergmann\Money\Currency
     * @depends testObjectCanBeConstructedForValidConstructorArgument
     */
    public function testConvertToBase(CurrencyPair $cp)
    {
        $m = $cp->convertToBase(new Money(1250, new Currency('USD')));

        $this->assertInstanceOf('SebastianBergmann\\Money\\Money', $m);

        $this->assertEquals(1000, $m->getAmount());
    }

    /**
     * @expectedException SebastianBergmann\Money\InvalidArgumentException
     * @covers  SebastianBergmann\Money\CurrencyPair::createFromString
     */
    public function testExceptionIsRaisedInCreateFromInvalidString()
    {
        CurrencyPair::createFromString("ABCD 0");
    }

    /**
     * @covers  SebastianBergmann\Money\CurrencyPair::createFromString
     * @depends testObjectCanBeConstructedForValidConstructorArgument
     */
    public function testCreateFromInvalidString(CurrencyPair $cp)
    {
        $stringCp = CurrencyPair::createFromString("EUR/USD 1.2500");
        
        $this->assertEquals($cp, $stringCp);
    }
}
