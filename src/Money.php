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

/**
 * Value Object that represents a monetary value
 * (using a currency's smallest unit).
 *
 * @package    Money
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2012-2014 Sebastian Bergmann <sebastian@phpunit.de>
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
     * @var \SebastianBergmann\Money\Currency
     */
    private $currency;

    /**
     * @var integer[]
     */
    private static $roundingModes = array(
        PHP_ROUND_HALF_UP,
        PHP_ROUND_HALF_DOWN,
        PHP_ROUND_HALF_EVEN,
        PHP_ROUND_HALF_ODD
    );

    /**
     * @param  integer                           $amount
     * @param  \SebastianBergmann\Money\Currency $currency
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    public function __construct($amount, Currency $currency)
    {
        if (!is_int($amount)) {
            throw new InvalidArgumentException('$amount must be an integer');
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
     * @return \SebastianBergmann\Money\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Returns a new Money object that represents the monetary value
     * of the sum of this Money object and another.
     *
     * @param  \SebastianBergmann\Money\Money $other
     * @return \SebastianBergmann\Money\Money
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     * @throws \SebastianBergmann\Money\OverflowException
     */
    public function add(Money $other)
    {
        $this->assertSameCurrency($this, $other);

        $value = $this->amount + $other->getAmount();

        $this->assertIsInteger($value);

        return $this->newMoney($value);
    }

    /**
     * Returns a new Money object that represents the monetary value
     * of the difference of this Money object and another.
     *
     * @param  \SebastianBergmann\Money\Money $other
     * @return \SebastianBergmann\Money\Money
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     * @throws \SebastianBergmann\Money\OverflowException
     */
    public function subtract(Money $other)
    {
        $this->assertSameCurrency($this, $other);

        $value = $this->amount - $other->getAmount();

        $this->assertIsInteger($value);

        return $this->newMoney($value);
    }

    /**
     * Returns a new Money object that represents the negated monetary value
     * of this Money object.
     *
     * @return \SebastianBergmann\Money\Money
     */
    public function negate()
    {
        return $this->newMoney(-1 * $this->amount);
    }

    /**
     * Returns a new Money object that represents the monetary value
     * of this Money object multiplied by a given factor.
     *
     * @param  float   $factor
     * @param  integer $roundingMode
     * @return \SebastianBergmann\Money\Money
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    public function multiply($factor, $roundingMode = PHP_ROUND_HALF_UP)
    {
        if (!in_array($roundingMode, self::$roundingModes)) {
            throw new InvalidArgumentException(
                '$roundingMode must be a valid rounding mode (PHP_ROUND_*)'
            );
        }

        return $this->newMoney(
            $this->castToInt(
                round($factor * $this->amount, 0, $roundingMode)
            )
        );
    }

    /**
     * Allocate the monetary value represented by this Money object
     * among N targets.
     *
     * @param  integer $n
     * @return \SebastianBergmann\Money\Money[]
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    public function allocateToTargets($n)
    {
        if (!is_int($n)) {
            throw new InvalidArgumentException('$n must be an integer');
        }

        $low       = $this->newMoney(intval($this->amount / $n));
        $high      = $this->newMoney($low->getAmount() + 1);
        $remainder = $this->amount % $n;
        $result    = array();

        for ($i = 0; $i < $remainder; $i++) {
            $result[] = $high;
        }

        for ($i = $remainder; $i < $n; $i++) {
            $result[] = $low;
        }

        return $result;
    }

    /**
     * Allocate the monetary value represented by this Money object
     * using a list of ratios.
     *
     * @param  array $ratios
     * @return \SebastianBergmann\Money\Money[]
     */
    public function allocateByRatios(array $ratios)
    {
        /** @var \SebastianBergmann\Money\Money[] $result */
        $result    = array();
        $total     = array_sum($ratios);
        $remainder = $this->amount;

        for ($i = 0; $i < count($ratios); $i++) {
            $amount     = $this->castToInt($this->amount * $ratios[$i] / $total);
            $result[]   = $this->newMoney($amount);
            $remainder -= $amount;
        }

        for ($i = 0; $i < $remainder; $i++) {
            $result[$i] = $this->newMoney($result[$i]->getAmount() + 1);
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
     * @param  \SebastianBergmann\Money\Money $other
     * @return integer -1|0|1
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function compareTo(Money $other)
    {
        $this->assertSameCurrency($this, $other);

        if ($this->amount == $other->getAmount()) {
            return 0;
        }

        return $this->amount < $other->getAmount() ? -1 : 1;
    }

    /**
     * Returns TRUE if this Money object equals to another.
     *
     * @param  \SebastianBergmann\Money\Money $other
     * @return boolean
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function equals(Money $other)
    {
        return $this->compareTo($other) == 0;
    }

    /**
     * Returns TRUE if the monetary value represented by this Money object
     * is greater than that of another, FALSE otherwise.
     *
     * @param  \SebastianBergmann\Money\Money $other
     * @return boolean
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function greaterThan(Money $other)
    {
        return $this->compareTo($other) == 1;
    }

    /**
     * Returns TRUE if the monetary value represented by this Money object
     * is greater than or equal that of another, FALSE otherwise.
     *
     * @param  \SebastianBergmann\Money\Money $other
     * @return boolean
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function greaterThanOrEqual(Money $other)
    {
        return $this->greaterThan($other) || $this->equals($other);
    }

    /**
     * Returns TRUE if the monetary value represented by this Money object
     * is smaller than that of another, FALSE otherwise.
     *
     * @param  \SebastianBergmann\Money\Money $other
     * @return boolean
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function lessThan(Money $other)
    {
        return $this->compareTo($other) == -1;
    }

    /**
     * Returns TRUE if the monetary value represented by this Money object
     * is smaller than or equal that of another, FALSE otherwise.
     *
     * @param  \SebastianBergmann\Money\Money $other
     * @return boolean
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    public function lessThanOrEqual(Money $other)
    {
        return $this->lessThan($other) || $this->equals($other);
    }

    /**
     * @param  \SebastianBergmann\Money\Money $a
     * @param  \SebastianBergmann\Money\Money $b
     * @throws \SebastianBergmann\Money\CurrencyMismatchException
     */
    private function assertSameCurrency(Money $a, Money $b)
    {
        if ($a->getCurrency() != $b->getCurrency()) {
            throw new CurrencyMismatchException;
        }
    }

    /**
     * Raises an exception if the amount is not an integer
     *
     * @param  number $amount
     * @return number
     * @throws \SebastianBergmann\Money\OverflowException
     */
    private function assertIsInteger($amount)
    {
        if (!is_int($amount)) {
            throw new OverflowException;
        }
    }// @codeCoverageIgnore

    /**
     * Raises an exception if the amount is outside of the integer bounds
     *
     * @param  number $amount
     * @return number
     * @throws \SebastianBergmann\Money\OverflowException
     */
    private function assertInsideIntegerBounds($amount)
    {
        if (abs($amount) > PHP_INT_MAX) {
            throw new OverflowException;
        }
    }// @codeCoverageIgnore

    /**
     * Cast an amount to an integer but ensure that the operation won't hide overflow
     *
     * @param number $amount
     * @return int
     * @throws \SebastianBergmann\Money\OverflowException
     */
    private function castToInt($amount)
    {
        $this->assertInsideIntegerBounds($amount);

        return intval($amount);
    }

    /**
     * @param  integer $amount
     * @return \SebastianBergmann\Money\Money
     */
    private function newMoney($amount)
    {
        return new static($amount, $this->currency);
    }
}
