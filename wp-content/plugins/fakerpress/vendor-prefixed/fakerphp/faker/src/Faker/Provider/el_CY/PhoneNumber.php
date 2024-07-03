<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Provider\el_CY;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '+3572#######',
        '+3579#######',
        '2#######',
        '9#######',
    ];

    /**
     * An array of el_CY mobile (cell) phone number formats.
     *
     * @var array
     */
    protected static $mobileFormats = [
        '9#######',
    ];

    /**
     * Return a el_CY mobile phone number.
     *
     * @return string
     */
    public static function mobileNumber()
    {
        return static::numerify(static::randomElement(static::$mobileFormats));
    }
}
