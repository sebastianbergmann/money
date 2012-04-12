<?php
namespace SebastianBergmann\Money
{
    interface MoneyInterface
    {
        public function getAmount();

        public function add(MoneyInterface $other);

        public function subtract(MoneyInterface $other);

        public function negate();

        public function multiply($factor);

        public function divide($denominator);

        public function compareTo(MoneyInterface $other);

        public function greaterThan(MoneyInterface $other);

        public function lessThan(MoneyInterface $other);
    }
}
