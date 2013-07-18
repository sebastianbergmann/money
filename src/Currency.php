<?php
/**
 * Money
 *
 * Copyright (c) 2012-2013, Sebastian Bergmann <sebastian@phpunit.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    Money
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2013 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.github.com/sebastianbergmann/money
 */
namespace SebastianBergmann\Money
{
    /**
     * Value Object that represents a currency.
     *
     * Loosely based on the java.util.Currency class of the Java SDK.
     *
     * @package    Money
     * @author     Sebastian Bergmann <sebastian@phpunit.de>
     * @copyright  2013 Sebastian Bergmann <sebastian@phpunit.de>
     * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
     * @link       http://www.github.com/sebastianbergmann/money
     * @see        http://docs.oracle.com/javase/7/docs/api/java/util/Currency.html
     */
    class Currency
    {
        /**
         * @var array
         */
        private static $currencies = array(
          'AED' => array(
            'display_name' => 'UAE Dirham',
            'numeric_code' => 784,
            'default_fraction_digits' => 2,
          ),
          'AFN' => array(
            'display_name' => 'Afghani',
            'numeric_code' => 971,
            'default_fraction_digits' => 2,
          ),
          'ALL' => array(
            'display_name' => 'Lek',
            'numeric_code' => 8,
            'default_fraction_digits' => 2,
          ),
          'AMD' => array(
            'display_name' => 'Armenian Dram',
            'numeric_code' => 51,
            'default_fraction_digits' => 2,
          ),
          'ANG' => array(
            'display_name' => 'Netherlands Antillean Guilder',
            'numeric_code' => 532,
            'default_fraction_digits' => 2,
          ),
          'AOA' => array(
            'display_name' => 'Kwanza',
            'numeric_code' => 973,
            'default_fraction_digits' => 2,
          ),
          'ARS' => array(
            'display_name' => 'Argentine Peso',
            'numeric_code' => 32,
            'default_fraction_digits' => 2,
          ),
          'AUD' => array(
            'display_name' => 'Australian Dollar',
            'numeric_code' => 36,
            'default_fraction_digits' => 2,
          ),
          'AWG' => array(
            'display_name' => 'Aruban Florin',
            'numeric_code' => 533,
            'default_fraction_digits' => 2,
          ),
          'AZN' => array(
            'display_name' => 'Azerbaijanian Manat',
            'numeric_code' => 944,
            'default_fraction_digits' => 2,
          ),
          'BAM' => array(
            'display_name' => 'Convertible Mark',
            'numeric_code' => 977,
            'default_fraction_digits' => 2,
          ),
          'BBD' => array(
            'display_name' => 'Barbados Dollar',
            'numeric_code' => 52,
            'default_fraction_digits' => 2,
          ),
          'BDT' => array(
            'display_name' => 'Taka',
            'numeric_code' => 50,
            'default_fraction_digits' => 2,
          ),
          'BGN' => array(
            'display_name' => 'Bulgarian Lev',
            'numeric_code' => 975,
            'default_fraction_digits' => 2,
          ),
          'BHD' => array(
            'display_name' => 'Bahraini Dinar',
            'numeric_code' => 48,
            'default_fraction_digits' => 3,
          ),
          'BIF' => array(
            'display_name' => 'Burundi Franc',
            'numeric_code' => 108,
            'default_fraction_digits' => 0,
          ),
          'BMD' => array(
            'display_name' => 'Bermudian Dollar',
            'numeric_code' => 60,
            'default_fraction_digits' => 2,
          ),
          'BND' => array(
            'display_name' => 'Brunei Dollar',
            'numeric_code' => 96,
            'default_fraction_digits' => 2,
          ),
          'BOB' => array(
            'display_name' => 'Boliviano',
            'numeric_code' => 68,
            'default_fraction_digits' => 2,
          ),
          'BOV' => array(
            'display_name' => 'Mvdol',
            'numeric_code' => 984,
            'default_fraction_digits' => 2,
          ),
          'BRL' => array(
            'display_name' => 'Brazilian Real',
            'numeric_code' => 986,
            'default_fraction_digits' => 2,
          ),
          'BSD' => array(
            'display_name' => 'Bahamian Dollar',
            'numeric_code' => 44,
            'default_fraction_digits' => 2,
          ),
          'BTN' => array(
            'display_name' => 'Ngultrum',
            'numeric_code' => 64,
            'default_fraction_digits' => 2,
          ),
          'BWP' => array(
            'display_name' => 'Pula',
            'numeric_code' => 72,
            'default_fraction_digits' => 2,
          ),
          'BYR' => array(
            'display_name' => 'Belarussian Ruble',
            'numeric_code' => 974,
            'default_fraction_digits' => 0,
          ),
          'BZD' => array(
            'display_name' => 'Belize Dollar',
            'numeric_code' => 84,
            'default_fraction_digits' => 2,
          ),
          'CAD' => array(
            'display_name' => 'Canadian Dollar',
            'numeric_code' => 124,
            'default_fraction_digits' => 2,
          ),
          'CDF' => array(
            'display_name' => 'Congolese Franc',
            'numeric_code' => 976,
            'default_fraction_digits' => 2,
          ),
          'CHE' => array(
            'display_name' => 'WIR Euro',
            'numeric_code' => 947,
            'default_fraction_digits' => 2,
          ),
          'CHF' => array(
            'display_name' => 'Swiss Franc',
            'numeric_code' => 756,
            'default_fraction_digits' => 2,
          ),
          'CHW' => array(
            'display_name' => 'WIR Franc',
            'numeric_code' => 948,
            'default_fraction_digits' => 2,
          ),
          'CLF' => array(
            'display_name' => 'Unidades de fomento',
            'numeric_code' => 990,
            'default_fraction_digits' => 0,
          ),
          'CLP' => array(
            'display_name' => 'Chilean Peso',
            'numeric_code' => 152,
            'default_fraction_digits' => 0,
          ),
          'CNY' => array(
            'display_name' => 'Yuan Renminbi',
            'numeric_code' => 156,
            'default_fraction_digits' => 2,
          ),
          'COP' => array(
            'display_name' => 'Colombian Peso',
            'numeric_code' => 170,
            'default_fraction_digits' => 2,
          ),
          'COU' => array(
            'display_name' => 'Unidad de Valor Real',
            'numeric_code' => 970,
            'default_fraction_digits' => 2,
          ),
          'CRC' => array(
            'display_name' => 'Costa Rican Colon',
            'numeric_code' => 188,
            'default_fraction_digits' => 2,
          ),
          'CUC' => array(
            'display_name' => 'Peso Convertible',
            'numeric_code' => 931,
            'default_fraction_digits' => 2,
          ),
          'CUP' => array(
            'display_name' => 'Cuban Peso',
            'numeric_code' => 192,
            'default_fraction_digits' => 2,
          ),
          'CVE' => array(
            'display_name' => 'Cape Verde Escudo',
            'numeric_code' => 132,
            'default_fraction_digits' => 2,
          ),
          'CZK' => array(
            'display_name' => 'Czech Koruna',
            'numeric_code' => 203,
            'default_fraction_digits' => 2,
          ),
          'DJF' => array(
            'display_name' => 'Djibouti Franc',
            'numeric_code' => 262,
            'default_fraction_digits' => 0,
          ),
          'DKK' => array(
            'display_name' => 'Danish Krone',
            'numeric_code' => 208,
            'default_fraction_digits' => 2,
          ),
          'DOP' => array(
            'display_name' => 'Dominican Peso',
            'numeric_code' => 214,
            'default_fraction_digits' => 2,
          ),
          'DZD' => array(
            'display_name' => 'Algerian Dinar',
            'numeric_code' => 12,
            'default_fraction_digits' => 2,
          ),
          'EGP' => array(
            'display_name' => 'Egyptian Pound',
            'numeric_code' => 818,
            'default_fraction_digits' => 2,
          ),
          'ERN' => array(
            'display_name' => 'Nakfa',
            'numeric_code' => 232,
            'default_fraction_digits' => 2,
          ),
          'ETB' => array(
            'display_name' => 'Ethiopian Birr',
            'numeric_code' => 230,
            'default_fraction_digits' => 2,
          ),
          'EUR' => array(
            'display_name' => 'Euro',
            'numeric_code' => 978,
            'default_fraction_digits' => 2,
          ),
          'FJD' => array(
            'display_name' => 'Fiji Dollar',
            'numeric_code' => 242,
            'default_fraction_digits' => 2,
          ),
          'FKP' => array(
            'display_name' => 'Falkland Islands Pound',
            'numeric_code' => 238,
            'default_fraction_digits' => 2,
          ),
          'GBP' => array(
            'display_name' => 'Pound Sterling',
            'numeric_code' => 826,
            'default_fraction_digits' => 2,
          ),
          'GEL' => array(
            'display_name' => 'Lari',
            'numeric_code' => 981,
            'default_fraction_digits' => 2,
          ),
          'GHS' => array(
            'display_name' => 'Ghana Cedi',
            'numeric_code' => 936,
            'default_fraction_digits' => 2,
          ),
          'GIP' => array(
            'display_name' => 'Gibraltar Pound',
            'numeric_code' => 292,
            'default_fraction_digits' => 2,
          ),
          'GMD' => array(
            'display_name' => 'Dalasi',
            'numeric_code' => 270,
            'default_fraction_digits' => 2,
          ),
          'GNF' => array(
            'display_name' => 'Guinea Franc',
            'numeric_code' => 324,
            'default_fraction_digits' => 0,
          ),
          'GTQ' => array(
            'display_name' => 'Quetzal',
            'numeric_code' => 320,
            'default_fraction_digits' => 2,
          ),
          'GYD' => array(
            'display_name' => 'Guyana Dollar',
            'numeric_code' => 328,
            'default_fraction_digits' => 2,
          ),
          'HKD' => array(
            'display_name' => 'Hong Kong Dollar',
            'numeric_code' => 344,
            'default_fraction_digits' => 2,
          ),
          'HNL' => array(
            'display_name' => 'Lempira',
            'numeric_code' => 340,
            'default_fraction_digits' => 2,
          ),
          'HRK' => array(
            'display_name' => 'Croatian Kuna',
            'numeric_code' => 191,
            'default_fraction_digits' => 2,
          ),
          'HTG' => array(
            'display_name' => 'Gourde',
            'numeric_code' => 332,
            'default_fraction_digits' => 2,
          ),
          'HUF' => array(
            'display_name' => 'Forint',
            'numeric_code' => 348,
            'default_fraction_digits' => 2,
          ),
          'IDR' => array(
            'display_name' => 'Rupiah',
            'numeric_code' => 360,
            'default_fraction_digits' => 2,
          ),
          'ILS' => array(
            'display_name' => 'New Israeli Sheqel',
            'numeric_code' => 376,
            'default_fraction_digits' => 2,
          ),
          'INR' => array(
            'display_name' => 'Indian Rupee',
            'numeric_code' => 356,
            'default_fraction_digits' => 2,
          ),
          'IQD' => array(
            'display_name' => 'Iraqi Dinar',
            'numeric_code' => 368,
            'default_fraction_digits' => 3,
          ),
          'IRR' => array(
            'display_name' => 'Iranian Rial',
            'numeric_code' => 364,
            'default_fraction_digits' => 2,
          ),
          'ISK' => array(
            'display_name' => 'Iceland Krona',
            'numeric_code' => 352,
            'default_fraction_digits' => 0,
          ),
          'JMD' => array(
            'display_name' => 'Jamaican Dollar',
            'numeric_code' => 388,
            'default_fraction_digits' => 2,
          ),
          'JOD' => array(
            'display_name' => 'Jordanian Dinar',
            'numeric_code' => 400,
            'default_fraction_digits' => 3,
          ),
          'JPY' => array(
            'display_name' => 'Yen',
            'numeric_code' => 392,
            'default_fraction_digits' => 0,
          ),
          'KES' => array(
            'display_name' => 'Kenyan Shilling',
            'numeric_code' => 404,
            'default_fraction_digits' => 2,
          ),
          'KGS' => array(
            'display_name' => 'Som',
            'numeric_code' => 417,
            'default_fraction_digits' => 2,
          ),
          'KHR' => array(
            'display_name' => 'Riel',
            'numeric_code' => 116,
            'default_fraction_digits' => 2,
          ),
          'KMF' => array(
            'display_name' => 'Comoro Franc',
            'numeric_code' => 174,
            'default_fraction_digits' => 0,
          ),
          'KPW' => array(
            'display_name' => 'North Korean Won',
            'numeric_code' => 408,
            'default_fraction_digits' => 2,
          ),
          'KRW' => array(
            'display_name' => 'Won',
            'numeric_code' => 410,
            'default_fraction_digits' => 0,
          ),
          'KWD' => array(
            'display_name' => 'Kuwaiti Dinar',
            'numeric_code' => 414,
            'default_fraction_digits' => 3,
          ),
          'KYD' => array(
            'display_name' => 'Cayman Islands Dollar',
            'numeric_code' => 136,
            'default_fraction_digits' => 2,
          ),
          'KZT' => array(
            'display_name' => 'Tenge',
            'numeric_code' => 398,
            'default_fraction_digits' => 2,
          ),
          'LAK' => array(
            'display_name' => 'Kip',
            'numeric_code' => 418,
            'default_fraction_digits' => 2,
          ),
          'LBP' => array(
            'display_name' => 'Lebanese Pound',
            'numeric_code' => 422,
            'default_fraction_digits' => 2,
          ),
          'LKR' => array(
            'display_name' => 'Sri Lanka Rupee',
            'numeric_code' => 144,
            'default_fraction_digits' => 2,
          ),
          'LRD' => array(
            'display_name' => 'Liberian Dollar',
            'numeric_code' => 430,
            'default_fraction_digits' => 2,
          ),
          'LSL' => array(
            'display_name' => 'Loti',
            'numeric_code' => 426,
            'default_fraction_digits' => 2,
          ),
          'LTL' => array(
            'display_name' => 'Lithuanian Litas',
            'numeric_code' => 440,
            'default_fraction_digits' => 2,
          ),
          'LVL' => array(
            'display_name' => 'Latvian Lats',
            'numeric_code' => 428,
            'default_fraction_digits' => 2,
          ),
          'LYD' => array(
            'display_name' => 'Libyan Dinar',
            'numeric_code' => 434,
            'default_fraction_digits' => 3,
          ),
          'MAD' => array(
            'display_name' => 'Moroccan Dirham',
            'numeric_code' => 504,
            'default_fraction_digits' => 2,
          ),
          'MDL' => array(
            'display_name' => 'Moldovan Leu',
            'numeric_code' => 498,
            'default_fraction_digits' => 2,
          ),
          'MGA' => array(
            'display_name' => 'Malagasy Ariary',
            'numeric_code' => 969,
            'default_fraction_digits' => 2,
          ),
          'MKD' => array(
            'display_name' => 'Denar',
            'numeric_code' => 807,
            'default_fraction_digits' => 2,
          ),
          'MMK' => array(
            'display_name' => 'Kyat',
            'numeric_code' => 104,
            'default_fraction_digits' => 2,
          ),
          'MNT' => array(
            'display_name' => 'Tugrik',
            'numeric_code' => 496,
            'default_fraction_digits' => 2,
          ),
          'MOP' => array(
            'display_name' => 'Pataca',
            'numeric_code' => 446,
            'default_fraction_digits' => 2,
          ),
          'MRO' => array(
            'display_name' => 'Ouguiya',
            'numeric_code' => 478,
            'default_fraction_digits' => 2,
          ),
          'MUR' => array(
            'display_name' => 'Mauritius Rupee',
            'numeric_code' => 480,
            'default_fraction_digits' => 2,
          ),
          'MVR' => array(
            'display_name' => 'Rufiyaa',
            'numeric_code' => 462,
            'default_fraction_digits' => 2,
          ),
          'MWK' => array(
            'display_name' => 'Kwacha',
            'numeric_code' => 454,
            'default_fraction_digits' => 2,
          ),
          'MXN' => array(
            'display_name' => 'Mexican Peso',
            'numeric_code' => 484,
            'default_fraction_digits' => 2,
          ),
          'MXV' => array(
            'display_name' => 'Mexican Unidad de Inversion (UDI)',
            'numeric_code' => 979,
            'default_fraction_digits' => 2,
          ),
          'MYR' => array(
            'display_name' => 'Malaysian Ringgit',
            'numeric_code' => 458,
            'default_fraction_digits' => 2,
          ),
          'MZN' => array(
            'display_name' => 'Mozambique Metical',
            'numeric_code' => 943,
            'default_fraction_digits' => 2,
          ),
          'NAD' => array(
            'display_name' => 'Namibia Dollar',
            'numeric_code' => 516,
            'default_fraction_digits' => 2,
          ),
          'NGN' => array(
            'display_name' => 'Naira',
            'numeric_code' => 566,
            'default_fraction_digits' => 2,
          ),
          'NIO' => array(
            'display_name' => 'Cordoba Oro',
            'numeric_code' => 558,
            'default_fraction_digits' => 2,
          ),
          'NOK' => array(
            'display_name' => 'Norwegian Krone',
            'numeric_code' => 578,
            'default_fraction_digits' => 2,
          ),
          'NPR' => array(
            'display_name' => 'Nepalese Rupee',
            'numeric_code' => 524,
            'default_fraction_digits' => 2,
          ),
          'NZD' => array(
            'display_name' => 'New Zealand Dollar',
            'numeric_code' => 554,
            'default_fraction_digits' => 2,
          ),
          'OMR' => array(
            'display_name' => 'Rial Omani',
            'numeric_code' => 512,
            'default_fraction_digits' => 3,
          ),
          'PAB' => array(
            'display_name' => 'Balboa',
            'numeric_code' => 590,
            'default_fraction_digits' => 2,
          ),
          'PEN' => array(
            'display_name' => 'Nuevo Sol',
            'numeric_code' => 604,
            'default_fraction_digits' => 2,
          ),
          'PGK' => array(
            'display_name' => 'Kina',
            'numeric_code' => 598,
            'default_fraction_digits' => 2,
          ),
          'PHP' => array(
            'display_name' => 'Philippine Peso',
            'numeric_code' => 608,
            'default_fraction_digits' => 2,
          ),
          'PKR' => array(
            'display_name' => 'Pakistan Rupee',
            'numeric_code' => 586,
            'default_fraction_digits' => 2,
          ),
          'PLN' => array(
            'display_name' => 'Zloty',
            'numeric_code' => 985,
            'default_fraction_digits' => 2,
          ),
          'PYG' => array(
            'display_name' => 'Guarani',
            'numeric_code' => 600,
            'default_fraction_digits' => 0,
          ),
          'QAR' => array(
            'display_name' => 'Qatari Rial',
            'numeric_code' => 634,
            'default_fraction_digits' => 2,
          ),
          'RON' => array(
            'display_name' => 'New Romanian Leu',
            'numeric_code' => 946,
            'default_fraction_digits' => 2,
          ),
          'RSD' => array(
            'display_name' => 'Serbian Dinar',
            'numeric_code' => 941,
            'default_fraction_digits' => 2,
          ),
          'RUB' => array(
            'display_name' => 'Russian Ruble',
            'numeric_code' => 643,
            'default_fraction_digits' => 2,
          ),
          'RWF' => array(
            'display_name' => 'Rwanda Franc',
            'numeric_code' => 646,
            'default_fraction_digits' => 0,
          ),
          'SAR' => array(
            'display_name' => 'Saudi Riyal',
            'numeric_code' => 682,
            'default_fraction_digits' => 2,
          ),
          'SBD' => array(
            'display_name' => 'Solomon Islands Dollar',
            'numeric_code' => 90,
            'default_fraction_digits' => 2,
          ),
          'SCR' => array(
            'display_name' => 'Seychelles Rupee',
            'numeric_code' => 690,
            'default_fraction_digits' => 2,
          ),
          'SDG' => array(
            'display_name' => 'Sudanese Pound',
            'numeric_code' => 938,
            'default_fraction_digits' => 2,
          ),
          'SEK' => array(
            'display_name' => 'Swedish Krona',
            'numeric_code' => 752,
            'default_fraction_digits' => 2,
          ),
          'SGD' => array(
            'display_name' => 'Singapore Dollar',
            'numeric_code' => 702,
            'default_fraction_digits' => 2,
          ),
          'SHP' => array(
            'display_name' => 'Saint Helena Pound',
            'numeric_code' => 654,
            'default_fraction_digits' => 2,
          ),
          'SLL' => array(
            'display_name' => 'Leone',
            'numeric_code' => 694,
            'default_fraction_digits' => 2,
          ),
          'SOS' => array(
            'display_name' => 'Somali Shilling',
            'numeric_code' => 706,
            'default_fraction_digits' => 2,
          ),
          'SRD' => array(
            'display_name' => 'Surinam Dollar',
            'numeric_code' => 968,
            'default_fraction_digits' => 2,
          ),
          'SSP' => array(
            'display_name' => 'South Sudanese Pound',
            'numeric_code' => 728,
            'default_fraction_digits' => 2,
          ),
          'STD' => array(
            'display_name' => 'Dobra',
            'numeric_code' => 678,
            'default_fraction_digits' => 2,
          ),
          'SVC' => array(
            'display_name' => 'El Salvador Colon',
            'numeric_code' => 222,
            'default_fraction_digits' => 2,
          ),
          'SYP' => array(
            'display_name' => 'Syrian Pound',
            'numeric_code' => 760,
            'default_fraction_digits' => 2,
          ),
          'SZL' => array(
            'display_name' => 'Lilangeni',
            'numeric_code' => 748,
            'default_fraction_digits' => 2,
          ),
          'THB' => array(
            'display_name' => 'Baht',
            'numeric_code' => 764,
            'default_fraction_digits' => 2,
          ),
          'TJS' => array(
            'display_name' => 'Somoni',
            'numeric_code' => 972,
            'default_fraction_digits' => 2,
          ),
          'TMT' => array(
            'display_name' => 'Turkmenistan New Manat',
            'numeric_code' => 934,
            'default_fraction_digits' => 2,
          ),
          'TND' => array(
            'display_name' => 'Tunisian Dinar',
            'numeric_code' => 788,
            'default_fraction_digits' => 3,
          ),
          'TOP' => array(
            'display_name' => 'Pa’anga',
            'numeric_code' => 776,
            'default_fraction_digits' => 2,
          ),
          'TRY' => array(
            'display_name' => 'Turkish Lira',
            'numeric_code' => 949,
            'default_fraction_digits' => 2,
          ),
          'TTD' => array(
            'display_name' => 'Trinidad and Tobago Dollar',
            'numeric_code' => 780,
            'default_fraction_digits' => 2,
          ),
          'TWD' => array(
            'display_name' => 'New Taiwan Dollar',
            'numeric_code' => 901,
            'default_fraction_digits' => 2,
          ),
          'TZS' => array(
            'display_name' => 'Tanzanian Shilling',
            'numeric_code' => 834,
            'default_fraction_digits' => 2,
          ),
          'UAH' => array(
            'display_name' => 'Hryvnia',
            'numeric_code' => 980,
            'default_fraction_digits' => 2,
          ),
          'UGX' => array(
            'display_name' => 'Uganda Shilling',
            'numeric_code' => 800,
            'default_fraction_digits' => 0,
          ),
          'USD' => array(
            'display_name' => 'US Dollar',
            'numeric_code' => 840,
            'default_fraction_digits' => 2,
          ),
          'USN' => array(
            'display_name' => 'US Dollar (Next day)',
            'numeric_code' => 997,
            'default_fraction_digits' => 2,
          ),
          'USS' => array(
            'display_name' => 'US Dollar (Same day)',
            'numeric_code' => 998,
            'default_fraction_digits' => 2,
          ),
          'UYI' => array(
            'display_name' => 'Uruguay Peso en Unidades Indexadas (URUIURUI)',
            'numeric_code' => 940,
            'default_fraction_digits' => 0,
          ),
          'UYU' => array(
            'display_name' => 'Peso Uruguayo',
            'numeric_code' => 858,
            'default_fraction_digits' => 2,
          ),
          'UZS' => array(
            'display_name' => 'Uzbekistan Sum',
            'numeric_code' => 860,
            'default_fraction_digits' => 2,
          ),
          'VEF' => array(
            'display_name' => 'Bolivar',
            'numeric_code' => 937,
            'default_fraction_digits' => 2,
          ),
          'VND' => array(
            'display_name' => 'Dong',
            'numeric_code' => 704,
            'default_fraction_digits' => 0,
          ),
          'VUV' => array(
            'display_name' => 'Vatu',
            'numeric_code' => 548,
            'default_fraction_digits' => 0,
          ),
          'WST' => array(
            'display_name' => 'Tala',
            'numeric_code' => 882,
            'default_fraction_digits' => 2,
          ),
          'XAF' => array(
            'display_name' => 'CFA Franc BEAC',
            'numeric_code' => 950,
            'default_fraction_digits' => 0,
          ),
          'XAG' => array(
            'display_name' => 'Silver',
            'numeric_code' => 961,
            'default_fraction_digits' => 0,
          ),
          'XAU' => array(
            'display_name' => 'Gold',
            'numeric_code' => 959,
            'default_fraction_digits' => 0,
          ),
          'XBA' => array(
            'display_name' => 'Bond Markets Unit European Composite Unit (EURCO)',
            'numeric_code' => 955,
            'default_fraction_digits' => 0,
          ),
          'XBB' => array(
            'display_name' => 'Bond Markets Unit European Monetary Unit (E.M.U.-6)',
            'numeric_code' => 956,
            'default_fraction_digits' => 0,
          ),
          'XBC' => array(
            'display_name' => 'Bond Markets Unit European Unit of Account 9 (E.U.A.-9)',
            'numeric_code' => 957,
            'default_fraction_digits' => 0,
          ),
          'XBD' => array(
            'display_name' => 'Bond Markets Unit European Unit of Account 17 (E.U.A.-17)',
            'numeric_code' => 958,
            'default_fraction_digits' => 0,
          ),
          'XCD' => array(
            'display_name' => 'East Caribbean Dollar',
            'numeric_code' => 951,
            'default_fraction_digits' => 2,
          ),
          'XDR' => array(
            'display_name' => 'SDR (Special Drawing Right)',
            'numeric_code' => 960,
            'default_fraction_digits' => 0,
          ),
          'XFU' => array(
            'display_name' => 'UIC-Franc',
            'numeric_code' => 958,
            'default_fraction_digits' => 0,
          ),
          'XOF' => array(
            'display_name' => 'CFA Franc BCEAO',
            'numeric_code' => 952,
            'default_fraction_digits' => 0,
          ),
          'XPD' => array(
            'display_name' => 'Palladium',
            'numeric_code' => 964,
            'default_fraction_digits' => 0,
          ),
          'XPF' => array(
            'display_name' => 'CFP Franc',
            'numeric_code' => 953,
            'default_fraction_digits' => 0,
          ),
          'XPT' => array(
            'display_name' => 'Platinum',
            'numeric_code' => 962,
            'default_fraction_digits' => 0,
          ),
          'XSU' => array(
            'display_name' => 'Sucre',
            'numeric_code' => 994,
            'default_fraction_digits' => 0,
          ),
          'XTS' => array(
            'display_name' => 'Codes specifically reserved for testing purposes',
            'numeric_code' => 963,
            'default_fraction_digits' => 0,
          ),
          'XUA' => array(
            'display_name' => 'ADB Unit of Account',
            'numeric_code' => 965,
            'default_fraction_digits' => 0,
          ),
          'XXX' => array(
            'display_name' => 'The codes assigned for transactions where no currency is involved',
            'numeric_code' => 999,
            'default_fraction_digits' => 0,
          ),
          'YER' => array(
            'display_name' => 'Yemeni Rial',
            'numeric_code' => 886,
            'default_fraction_digits' => 2,
          ),
          'ZAR' => array(
            'display_name' => 'Rand',
            'numeric_code' => 710,
            'default_fraction_digits' => 2,
          ),
          'ZMW' => array(
            'display_name' => 'Zambian Kwacha',
            'numeric_code' => 967,
            'default_fraction_digits' => 2,
          ),
          'ZWL' => array(
            'display_name' => 'Zimbabwe Dollar',
            'numeric_code' => 932,
            'default_fraction_digits' => 2,
          )
        );

        /**
         * @var string
         */
        private $currencyCode;

        /**
         * @param  string $currencyCode
         * @throws SebastianBergmann\Money\InvalidArgumentException
         */
        public function __construct($currencyCode)
        {
            if (!isset(self::$currencies[$currencyCode])) {
                throw new InvalidArgumentException(
                  '$currencyCode must be an ISO 4217 currency code'
                );
            }

            $this->currencyCode = $currencyCode;
        }

        /**
         * Returns the ISO 4217 currency code of this currency.
         *
         * @return string
         */
        public function getCurrencyCode()
        {
            return $this->currencyCode;
        }

        /**
         * Returns the default number of fraction digits used with this
         * currency.
         *
         * @return integer
         */
        public function getDefaultFractionDigits()
        {
            return self::$currencies[$this->currencyCode]['default_fraction_digits'];
        }

        /**
         * Returns the name that is suitable for displaying this currency.
         *
         * @return string
         */
        public function getDisplayName()
        {
            return self::$currencies[$this->currencyCode]['display_name'];
        }

        /**
         * Returns the ISO 4217 numeric code of this currency.
         *
         * @return integer
         */
        public function getNumericCode()
        {
            return self::$currencies[$this->currencyCode]['numeric_code'];
        }

        /**
         * Returns the ISO 4217 currency code of this currency.
         *
         * @return string
         */
        public function __toString()
        {
            return $this->currencyCode;
        }
    }
}
