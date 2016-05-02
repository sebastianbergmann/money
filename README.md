**This project has been abandoned.** It was only ever intended to be used as an example for PHPUnit features etc. and not for usage in production. I am sorry that I failed to make that clear. Please have a look at [moneyphp/money](https://github.com/moneyphp/money) instead.

# Money

[Value Object](http://martinfowler.com/bliki/ValueObject.html) that represents a [monetary value using a currency's smallest unit](http://martinfowler.com/eaaCatalog/money.html).

## Installation

Simply add a dependency on `sebastian/money` to your project's `composer.json` file if you use [Composer](http://getcomposer.org/) to manage the dependencies of your project.

Here is a minimal example of a `composer.json` file that just defines a dependency on Money:

    {
        "require": {
            "sebastian/money": "^1.6"
        }
    }

## Usage Examples

#### Creating a Money object and accessing its monetary value

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

// Create Money object that represents 1 EUR
$m = new Money(100, new Currency('EUR'));

// Access the Money object's monetary value
print $m->getAmount();

// Access the Money object's monetary value converted to its base units
print $m->getConvertedAmount();
```

The code above produces the output shown below:

    100
    
    1.00

#### Creating a Money object from a string value

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

// Create Money object that represents 12.34 EUR
$m = Money::fromString('12.34', new Currency('EUR'))

// Access the Money object's monetary value
print $m->getAmount();
```

The code above produces the output shown below:

    1234

#### Using a Currency-specific subclass of Money

```php
use SebastianBergmann\Money\EUR;

// Create Money object that represents 1 EUR
$m = new EUR(100);

// Access the Money object's monetary value
print $m->getAmount();
```

The code above produces the output shown below:

    100

Please note that there is no subclass of `Money` that is specific to Turkish Lira as `TRY` is not a valid class name in PHP.

#### Formatting a Money object using PHP's built-in NumberFormatter

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\IntlFormatter;

// Create Money object that represents 1 EUR
$m = new Money(100, new Currency('EUR'));

// Format a Money object using PHP's built-in NumberFormatter (German locale)
$f = new IntlFormatter('de_DE');

print $f->format($m);
```

The code above produces the output shown below:

    1,00 €

#### Basic arithmetic using Money objects

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

// Create two Money objects that represent 1 EUR and 2 EUR, respectively
$a = new Money(100, new Currency('EUR'));
$b = new Money(200, new Currency('EUR'));

// Negate a Money object
$c = $a->negate();
print $c->getAmount();

// Calculate the sum of two Money objects
$c = $a->add($b);
print $c->getAmount();

// Calculate the difference of two Money objects
$c = $b->subtract($a);
print $c->getAmount();

// Multiply a Money object with a factor
$c = $a->multiply(2);
print $c->getAmount();
```

The code above produces the output shown below:

    -100
    300
    100
    200

#### Comparing Money objects

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

// Create two Money objects that represent 1 EUR and 2 EUR, respectively
$a = new Money(100, new Currency('EUR'));
$b = new Money(200, new Currency('EUR'));

var_dump($a->lessThan($b));
var_dump($a->greaterThan($b));

var_dump($b->lessThan($a));
var_dump($b->greaterThan($a));

var_dump($a->compareTo($b));
var_dump($a->compareTo($a));
var_dump($b->compareTo($a));
```

The code above produces the output shown below:

    bool(true)
    bool(false)
    bool(false)
    bool(true)
    int(-1)
    int(0)
    int(1)

The `compareTo()` method returns an integer less than, equal to, or greater than
zero if the value of one `Money` object is considered to be respectively less
than, equal to, or greater than that of another `Money` object.

You can use the `compareTo()` method to sort an array of `Money` objects using
PHP's built-in sorting functions:

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

$m = array(
    new Money(300, new Currency('EUR')),
    new Money(100, new Currency('EUR')),
    new Money(200, new Currency('EUR'))
);

usort(
    $m,
    function ($a, $b) { return $a->compareTo($b); }
);

foreach ($m as $_m) {
    print $_m->getAmount() . "\n";
}
```

The code above produces the output shown below:

    100
    200
    300

#### Allocate the monetary value represented by a Money object among N targets

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

// Create a Money object that represents 0,99 EUR
$a = new Money(99, new Currency('EUR'));

foreach ($a->allocateToTargets(10) as $t) {
    print $t->getAmount() . "\n";
}
```

The code above produces the output shown below:

    10
    10
    10
    10
    10
    10
    10
    10
    10
    9

#### Allocate the monetary value represented by a Money object using a list of ratios

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

// Create a Money object that represents 0,05 EUR
$a = new Money(5, new Currency('EUR'));

foreach ($a->allocateByRatios(array(3, 7)) as $t) {
    print $t->getAmount() . "\n";
}
```

The code above produces the output shown below:

    2
    3

#### Extract a percentage (and a subtotal) from the monetary value represented by a Money object

```php
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

// Create a Money object that represents 100,00 EUR
$original = new Money(10000, new Currency('EUR'));

// Extract 21% (and the corresponding subtotal)
$extract = $original->extractPercentage(21);

printf(
    "%d = %d + %d\n",
    $original->getAmount(),
    $extract['subtotal']->getAmount(),
    $extract['percentage']->getAmount()
);
```

The code above produces the output shown below:

    10000 = 8265 + 1735

Please note that this extracts the percentage out of a monetary value where the
percentage is already included. If you want to get the percentage of the
monetary value you should use multiplication (`multiply(0.21)`, for instance,
to calculate 21% of a monetary value represented by a Money object) instead.
