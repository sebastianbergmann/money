<?php
/*
 * This file is part of the Money package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianBergmann\Money;

/**
 * Value Object that represents a monetary value
 * (using a currency's smallest unit).
 *
 * @package    Money
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.github.com/sebastianbergmann/money
 * @see        http://martinfowler.com/bliki/ValueObject.html
 * @see        http://martinfowler.com/eaaCatalog/money.html
 */
class Money implements \JsonSerializable
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
    private static $roundingModes = [
        PHP_ROUND_HALF_UP,
        PHP_ROUND_HALF_DOWN,
        PHP_ROUND_HALF_EVEN,
        PHP_ROUND_HALF_ODD
    ];

    /**
     * @param  integer                                  $amount
     * @param  \SebastianBergmann\Money\Currency|string $currency
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    public function __construct($amount, $currency)
    {
        if (!is_int($amount)) {
            throw new InvalidArgumentException('$amount must be an integer');
        }

        $this->amount   = $amount;
        $this->currency = $this->handleCurrencyArgument($currency);
    }

    /**
     * Creates a Money object from a string such as "12.34"
     *
     * This method is designed to take into account the errors that can arise
     * from manipulating floating point numbers.
     *
     * If the number of decimals in the string is higher than the currency's
     * number of fractional digits then the value will be rounded to the
     * currency's number of fractional digits.
     *
     * @param  string                                   $value
     * @param  \SebastianBergmann\Money\Currency|string $currency
     * @return static
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    public static function fromString($value, $currency)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('$value must be a string');
        }

        $currency = self::handleCurrencyArgument($currency);

        return new static(
            intval(
                round(
                    $currency->getSubUnit() *
                    round(
                        $value,
                        $currency->getDefaultFractionDigits(),
                        PHP_ROUND_HALF_UP
                    ),
                    0,
                    PHP_ROUND_HALF_UP
                )
            ),
            $currency
        );
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * @link   http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize()
    {
        return [
            'amount'   => $this->amount,
            'currency' => $this->currency->getCurrencyCode()
        ];
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
     * return the monetary value represented by this object converted to its base units
     *
     * @return float
     */
    public function getConvertedAmount()
    {
        return round($this->amount / $this->currency->getSubUnit(), $this->currency->getDefaultFractionDigits());
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static[]
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    public function allocateToTargets($n)
    {
        if (!is_int($n)) {
            throw new InvalidArgumentException('$n must be an integer');
        }

        $sign       = ($this->amount < 0) ? -1 : 1;
        $amount     = abs($this->amount);
        $low        = $this->newMoney(intval($amount / $n));
        $high       = $this->newMoney($low->getAmount() + 1);
        $remainder  = $amount % $n;
        $result     = [];

        for ($i = 0; $i < $remainder; $i++) {
            $result[] = $high->multiply($sign);
        }

        for ($i = $remainder; $i < $n; $i++) {
            $result[] = $low->multiply($sign);
        }

        return $result;
    }

    /**
     * Allocate the monetary value represented by this Money object
     * using a list of ratios.
     *
     * @param  array $ratios
     * @return static[]
     */
    public function allocateByRatios(array $ratios)
    {
        /** @var \SebastianBergmann\Money\Money[] $result */
        $result    = [];
        $total     = array_sum($ratios);
        $sign      = ($this->amount < 0) ? -1 : 1;
        $absAmount = abs($this->amount);
        $remainder = $absAmount;

        for ($i = 0; $i < count($ratios); $i++) {
            $amount     = $this->castToInt($absAmount * $ratios[$i] / $total);
            $result[]   = $this->newMoney($amount)->multiply($sign);
            $remainder -= $amount;
        }

        for ($i = 0; $i < $remainder; $i++) {
            $result[$i] = $this->newMoney($result[$i]->getAmount() + $sign);
        }

        return $result;
    }

    /**
     * Extracts a percentage of the monetary value represented by this Money
     * object and returns an array of two Money objects:
     * $original = $result['subtotal'] + $result['percentage'];
     *
     * Please note that this extracts the percentage out of a monetary value
     * where the percentage is already included. If you want to get the
     * percentage of the monetary value you should use multiplication
     * (multiply(0.21), for instance, to calculate 21% of a monetary value
     * represented by a Money object) instead.
     *
     * @param  float $percentage
     * @param  integer $roundingMode
     * @return static[]
     * @see    https://github.com/sebastianbergmann/money/issues/27
     */
    public function extractPercentage($percentage, $roundingMode = PHP_ROUND_HALF_UP)
    {
        $percentage = $this->newMoney(
            $this->castToInt(
                round($this->amount / (100 + $percentage) * $percentage, 0, $roundingMode)
            )
        );

        return [
            'percentage' => $percentage,
            'subtotal'   => $this->subtract($percentage)
        ];
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
     * @return static
     */
    private function newMoney($amount)
    {
        return new static($amount, $this->currency);
    }

    /**
     * @param  \SebastianBergmann\Money\Currency|string $currency
     * @return \SebastianBergmann\Money\Currency
     * @throws \SebastianBergmann\Money\InvalidArgumentException
     */
    private static function handleCurrencyArgument($currency)
    {
        if (!$currency instanceof Currency && !is_string($currency)) {
            throw new InvalidArgumentException('$currency must be an object of type Currency or a string');
        }

        if (is_string($currency)) {
            $currency = new Currency($currency);
        }

        return $currency;
    }
}
