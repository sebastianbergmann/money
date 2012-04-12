<?php
namespace SebastianBergmann\Money
{
    class Money implements MoneyInterface
    {
        private $amount;

        public function __construct($amount)
        {
            if (!is_int($amount)) {
                throw new InvalidArgumentException(
                  '$amount must be an integer'
                );
            }

            $this->amount = $amount;
        }

        public function getAmount()
        {
            return $this->amount;
        }

        public function add(MoneyInterface $other)
        {
            return new Money($this->amount + $other->getAmount());
        }

        public function subtract(MoneyInterface $other)
        {
            return new Money($this->amount - $other->getAmount());
        }

        public function negate()
        {
            return new Money(-1 * $this->amount);
        }

        public function multiply($factor)
        {
            return new Money($factor * $this->amount);
        }

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

        public function compareTo(MoneyInterface $other)
        {
            if ($this->amount == $other->getAmount()) {
                return 0;
            }

            return $this->amount < $other->getAmount() ? -1 : 1;
        }

        public function greaterThan(MoneyInterface $other)
        {
            return $this->compareTo($other) == 1;
        }

        public function lessThan(MoneyInterface $other)
        {
            return $this->compareTo($other) == -1;
        }
    }
}
