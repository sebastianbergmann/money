#!/usr/bin/env php
<?php
/*
 * This file is part of the Money package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ . '/../src/autoload.php';

$template  = file_get_contents(__DIR__ . '/child-class.tpl');
$class     = new ReflectionClass('SebastianBergmann\Money\Currency');
$attribute = $class->getProperty('currencies');
$attribute->setAccessible(true);

foreach (array_keys($attribute->getValue()) as $currencyCode) {
    if ($currencyCode == 'TRY') {
        continue;
    }

    file_put_contents(
        __DIR__ . '/../src/currency/' . $currencyCode . '.php',
        str_replace(
            '{currencyCode}',
            $currencyCode,
            $template
        )
    );
}
