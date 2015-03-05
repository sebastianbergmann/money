# Changes in Money 2.0

## Money 2.0.0 (not yet released)

* Dropped support for PHP < 5.4.0

# Changes in Money 1.5

## Money 1.5.1

* Added the optional `$roundingMode` argument to the `Money::extractPercentage()` method
* Added support for arbitrary currencies that are not part of ISO 4217 to the `Currency` class
* Added support for lower-case currency strings
* The `Money` class now implements PHP's built-in `JsonSerializable` interface
* Changed the sub-unit of Japanese Yen from `100` to `1`

## Money 1.5.0

* Added the `Money::extractPercentage()` method for extracting a percentage and the corresponding subtotal

# Changes in Money 1.4

## Money 1.4.0

* Added the `Money::createFromString()` named constructor to create `Money` objects from strings such as `"12.34"`
* Changed `Money::__construct()` to accept an ISO 4217 currency code as its second argument

# Changes in Money 1.3

## Money 1.3.1

* Added support for late static binding to the `Money::newMoney()` method
* Added checks to ensure that internal operations do not disguise imprecision

## Money 1.3.0

* Added (automatically generated) `Currency`-specific subclasses of `Money`

# Changes in Money 1.2

## Money 1.2.0

* Implemented rounding support for the `Money::multiply()` method

# Changes in Money 1.1

## Money 1.1.0

* Added `Money::equals()`, `Money::greaterThanOrEqual()`, and `Money::lessThanOrEqual()` methods

# Changes in Money 1.0

## Money 1.0.0

* Initial release

