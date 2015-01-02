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
 * @package    Money
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @since      Class available since Release 1.3.0
 * @codeCoverageIgnore
 */
class {currencyCode} extends Money
{
    public function __construct($amount)
    {
        parent::__construct($amount, new Currency('{currencyCode}'));
    }
}
