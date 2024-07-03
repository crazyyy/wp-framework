<?php
/**
 * @license MIT
 *
 * Modified by Gustavo Bordoni on 22-April-2024 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace FakerPress\ThirdParty\Faker\Provider\ne_NP;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '01-4######',
        '01-5######',
        '01-6######',
        '9841######',
        '9849######',
        '98510#####',
        '9803######',
        '9808######',
        '9813######',
        '9818######',
    ];
}
