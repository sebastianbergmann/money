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
    /**
     * Value Object that represents a monetary value
     * (using a currency's smallest unit).
     *
     * @package    Money
     * @author     Sebastian Bergmann <sebastian@phpunit.de>
     * @copyright  2013 Sebastian Bergmann <sebastian@phpunit.de>
     * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
     * @link       http://www.github.com/sebastianbergmann/money
     * @see        http://martinfowler.com/bliki/ValueObject.html
     * @see        http://martinfowler.com/eaaCatalog/money.html
     */
    class Money
    {
        /**
         * @var integer
         */
        private $amount;

        /**
         * @var SebastianBergmann\Money\Currency
         */
        private $currency;

        /**
         * @param  integer                          $amount
         * @param  SebastianBergmann\Money\Currency $currency
         * @throws SebastianBergmann\Money\InvalidArgumentException
         */
        public function __construct($amount, Currency $currency)
        {
            if (!is_int($amount)) {
                throw new InvalidArgumentException(
                  '$amount must be an integer'
                );
            }

            $this->amount   = $amount;
            $this->currency = $currency;
        }

        /**
         * Returns the monetary value represented by this object.
         *
         * @return integer
         */
        public function getAmount()
        {
            return $this->amount;
        }

        /**
         * Returns the currency of the monetary value represented by this
         * object.
         *
         * @return integer
         */
        public function getCurrency()
        {
            return $this->currency;
        }

        /**
         * Returns a new Money object that represents the monetary value
         * of the sum of this Money object and another.
         *
         * @param  SebastianBergmann\Money\Money $other
         * @return SebastianBergmann\Money\Money
         * @throws SebastianBergmann\Money\CurrencyMismatchException
         */
        public function add(Money $other)
        {
            if ($this->currency != $other->getCurrency()) {
                throw new CurrencyMismatchException;
            }

            return new Money(
              $this->amount + $other->getAmount(), $this->currency
            );
        }

        /**
         * Returns a new Money object that represents the monetary value
         * of the difference of this Money object and another.
         *
         * @param  SebastianBergmann\Money\Money $other
         * @return SebastianBergmann\Money\Money
         * @throws SebastianBergmann\Money\CurrencyMismatchException
         */
        public function subtract(Money $other)
        {
            if ($this->currency != $other->getCurrency()) {
                throw new CurrencyMismatchException;
            }

            return new Money(
              $this->amount - $other->getAmount(), $this->currency
            );
        }

        /**
         * Returns a new Money object that represents the negated monetary value
         * of this Money object.
         *
         * @return SebastianBergmann\Money\Money
         */
        public function negate()
        {
            return new Money(-1 * $this->amount, $this->currency);
        }

        /**
         * Returns a new Money object that represents the monetary value
         * of this Money object multiplied by a given factor.
         *
         * @param  float $factor
         * @return SebastianBergmann\Money\Money
         */
        public function multiply($factor)
        {
            return new Money($factor * $this->amount, $this->currency);
        }

        /**
         * Returns an array of N Money objects (N = $denominator) into which the
         * monetary value of this Money object is divided.
         *
         * @param  integer $denominator
         * @return SebastianBergmann\Money\Money[]
         */
        public function divide($denominator)
        {
            $result       = array();
            $simpleResult = intval($this->amount / $denominator);
            $remainder    = $this->amount - $simpleResult * $denominator;

            for ($i = 0; $i < $denominator; $i++) {
                $result[$i] = new Money($simpleResult, $this->currency);
            }

            for ($i = 0; $i < $remainder; $i++) {
                $result[$i] = $result[$i]->add(new Money(1, $this->currency));
            }

            return $result;
        }

        /**
         * Compares this Money object to another.
         *
         * Returns an integer less than, equal to, or greater than zero
         * if the value of this Money object is considered to be respectively
         * less than, equal to, or greater than the other Money object.
         *
         * @param  SebastianBergmann\Money\Money $other
         * @return -1|0|1
         * @throws SebastianBergmann\Money\CurrencyMismatchException
         */
        public function compareTo(Money $other)
        {
            if ($this->currency != $other->getCurrency()) {
                throw new CurrencyMismatchException;
            }

            if ($this->amount == $other->getAmount()) {
                return 0;
            }

            return $this->amount < $other->getAmount() ? -1 : 1;
        }

        /**
         * Returns TRUE if the monetary value represented by this Money object
         * is greater than that of another, FALSE otherwise.
         *
         * @param  SebastianBergmann\Money\Money $other
         * @return boolean
         * @throws SebastianBergmann\Money\CurrencyMismatchException
         */
        public function greaterThan(Money $other)
        {
            return $this->compareTo($other) == 1;
        }

        /**
         * Returns TRUE if the monetary value represented by this Money object
         * is smaller than that of another, FALSE otherwise.
         *
         * @param  SebastianBergmann\Money\Money $other
         * @return boolean
         * @throws SebastianBergmann\Money\CurrencyMismatchException
         */
        public function lessThan(Money $other)
        {
            return $this->compareTo($other) == -1;
        }
    }
}
