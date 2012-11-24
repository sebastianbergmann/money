<?php
namespace SebastianBergmann\Money
{
    /**
     * Value Object that represents a monetary value
     * (using a currency's smallest unit).
     *
     * @see http://martinfowler.com/bliki/ValueObject.html
     * @see http://martinfowler.com/eaaCatalog/money.html
     */
    class Money
    {
        /**
         * @var integer
         */
        private $amount;

        /**
         * @param  integer $amount
         * @throws SebastianBergmann\Money\InvalidArgumentException
         */
        public function __construct($amount)
        {
            if (!is_int($amount)) {
                throw new InvalidArgumentException(
                  '$amount must be an integer'
                );
            }

            $this->amount = $amount;
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
         * Returns a new Money object that represents the monetary value
         * of the sum of this Money object and another.
         *
         * @param  SebastianBergmann\Money\Money $other
         * @return SebastianBergmann\Money\Money
         */
        public function add(Money $other)
        {
            return new Money($this->amount + $other->getAmount());
        }

        /**
         * Returns a new Money object that represents the monetary value
         * of the difference of this Money object and another.
         *
         * @param  SebastianBergmann\Money\Money $other
         * @return SebastianBergmann\Money\Money
         */
        public function subtract(Money $other)
        {
            return new Money($this->amount - $other->getAmount());
        }

        /**
         * Returns a new Money object that represents the negated monetary value
         * of this Money object.
         *
         * @return SebastianBergmann\Money\Money
         */
        public function negate()
        {
            return new Money(-1 * $this->amount);
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
            return new Money($factor * $this->amount);
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
                $result[$i] = new Money($simpleResult);
            }

            for ($i = 0; $i < $remainder; $i++) {
                $result[$i] = $result[$i]->add(new Money(1));
            }

            return $result;
        }

        /**
         * Compares this Money object to another.
         *
         * @param  SebastianBergmann\Money\Money $other
         * @return -1|0|1
         */
        public function compareTo(Money $other)
        {
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
         */
        public function lessThan(Money $other)
        {
            return $this->compareTo($other) == -1;
        }
    }
}
