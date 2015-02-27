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

use NumberFormatter;

/**
 * Formatter implementation that uses PHP's built-in NumberFormatter.
 *
 * @package    Money
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.github.com/sebastianbergmann/money
 */
class IntlFormatter implements Formatter
{
    /**
     * @var NumberFormatter
     */
    private $numberFormatter;

    /**
     * @param string $locale
     */
    public function __construct($locale)
    {
        $this->numberFormatter = new NumberFormatter(
            $locale,
            NumberFormatter::CURRENCY
        );
    }

    /**
     * Formats a Money object using PHP's built-in NumberFormatter.
     *
     * @param  \SebastianBergmann\Money\Money $money
     * @return string
     */
    public function format(Money $money)
    {
        return $this->numberFormatter->formatCurrency(
            $money->getConvertedAmount(),
            $money->getCurrency()->getCurrencyCode()
        );
    }
}
