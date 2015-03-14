# Change Log

All notable changes to `sebastianbergmann/money` will be documented in this file. Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [2.0.0] - not yet released

### Added
* Added the `Money::getConvertedAmount()` method for converting a `Money` object's amount into its base units
* Added the `Currency::getCurrencies()` method for retrieving the registered currencies
* Added the `IntlFormatter::fromLocale()` named constructor to create `IntlFormatter` objects for a specified locale
* Added the ability to pass in multiple types of values to the `Money` constructor, not just integers. It will now take integers, floats, strings integers (`[0-9]+`), and string floats (`[0-9]+(\.[0-9]+)?`), and convert them appropriately for internal storage as integers.
* Added a 3rd parameter to the `Money` constructor which allows the user to pass in a value in either the currency's subunits (ex. cents) or base units (ex. dollar). Parameters defaults to `false` and the value is interpreted as subunits, but if `true` is passed `Money` class will treat the value as base units, and convert them for internal storage appropriately.

### Changed
* The constructor of the `IntlFormatter` class now expects a `NumberFormatter` object

## Deprecated
* `Money::fromString()` method which allowed to create a money object from a string. A string value can now be passed to the constructor, and `Money` will interpret it appropriately

### Removed
* Removed support for PHP < 5.5.0

## [1.5.1] - 2015-02-22

### Added
* Added the optional `$roundingMode` argument to the `Money::extractPercentage()` method
* Added support for arbitrary currencies that are not part of ISO 4217 to the `Currency` class
* Added support for lower-case currency strings
* The `Money` class now implements PHP's built-in `JsonSerializable` interface

### Changed
* Changed the sub-unit of Japanese Yen from `100` to `1`

## [1.5.0] - 2014-09-05

### Added
* Added the `Money::extractPercentage()` method for extracting a percentage and the corresponding subtotal

## [1.4.0] - 2014-09-03

### Added
* Added the `Money::createFromString()` named constructor to create `Money` objects from strings such as `"12.34"`

### Changed
* Changed `Money::__construct()` to accept an ISO 4217 currency code as its second argument

## [1.3.1] - 2014-07-21

### Added
* Added support for late static binding to the `Money::newMoney()` method
* Added checks to ensure that internal operations do not disguise imprecision

## [1.3.0] - 2013-11-13

### Added
* Added (automatically generated) `Currency`-specific subclasses of `Money`

## [1.2.0] - 2013-10-19

### Added
* Implemented rounding support for the `Money::multiply()` method

## [1.1.0] - 2013-10-16

### Added
* Added `Money::equals()`, `Money::greaterThanOrEqual()`, and `Money::lessThanOrEqual()` methods

## 1.0.0 - 2013-07-21

### Added
* Initial release

[2.0.0]: https://github.com/sebastianbergmann/money/compare/v1.5.1...HEAD
[1.5.1]: https://github.com/sebastianbergmann/money/compare/v1.5.0...v1.5.1
[1.5.0]: https://github.com/sebastianbergmann/money/compare/v1.4.0...v1.5.0
[1.4.0]: https://github.com/sebastianbergmann/money/compare/v1.3.1...v1.4.0
[1.3.1]: https://github.com/sebastianbergmann/money/compare/v1.3.0...v1.3.1
[1.3.0]: https://github.com/sebastianbergmann/money/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/sebastianbergmann/money/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/sebastianbergmann/money/compare/v1.0.0...v1.1.0
