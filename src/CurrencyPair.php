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

/**
 * Implementation of a currency pair. See http://en.wikipedia.org/wiki/Currency_pair
 *
 * @package    Money
 * @author     Cam Spiers <camspiers@gmail.com>
 * @copyright  2013 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.github.com/sebastianbergmann/money
 */
class CurrencyPair
{
    /**
     * @var \SebastianBergmann\Money\Currency
     */
    private $baseCurrency;
    
    /**
     * @var \SebastianBergmann\Money\Currency
     */
    private $counterCurrency;
    
    /**
     * @var float
     */
    private $quote;

    /**
     * Create a CurrencyPair using a base and counter currency and a quote
     * to facilitate conversion between them.
     * 
     * @param \SebastianBergmann\Money\Currency $baseCurrency
     * @param \SebastianBergmann\Money\Currency $counterCurrency
     * @param float                             $quote
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    public function __construct(Currency $baseCurrency, Currency $counterCurrency, $quote)
    {
        if (!is_numeric($quote)) {
            throw new InvalidArgumentException('$quote must be numeric');
        }
        
        $this->baseCurrency = $baseCurrency;
        $this->counterCurrency = $counterCurrency;
        $this->quote = (float) $quote;
    }

    /**
     * Takes a money object in the base currency and converts it to the counter currency
     * 
     * @param Money $money
     * @return Money
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function convertToCounter(Money $money)
    {
        if ($money->getCurrency() != $this->baseCurrency) {
            throw new CurrencyMismatchException("Base currency does not match money currency");
        }

        return $money->multiply($this->quote, $this->counterCurrency);
    }

    /**
     * Takes a money object in the counter currency and converts it to the base currency
     * 
     * @param Money $money
     * @return Money
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function convertToBase(Money $money)
    {
        if ($money->getCurrency() != $this->counterCurrency) {
            throw new CurrencyMismatchException("Counter currency does not match money currency");
        }

        return $money->divide($this->quote, $this->baseCurrency);
    }

    /**
     * Creates a currency pair object from a currency pair string
     * e.g. "EUR/USD 1.2500", "EUR-USD 1.2500", "EURUSD 1.2500"
     * 
     * @param $string
     * @return static
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    public static function createFromString($string)
    {
        $matches = array();
        
        if (!preg_match('%([A-Z]{3})[/-]?([A-Z]{3}) ([0-9]*\.?[0-9]+)%', $string, $matches)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Invalid currency pair string '%s'",
                    $string
                )
            );
        }

        return new self(new Currency($matches[1]), new Currency($matches[2]), $matches[3]);
    }
}