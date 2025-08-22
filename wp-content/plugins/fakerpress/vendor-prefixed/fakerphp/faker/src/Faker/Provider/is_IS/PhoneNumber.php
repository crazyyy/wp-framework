<?php

namespace FakerPress\ThirdParty\Faker\Provider\is_IS;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    /**
     * @var array Icelandic phone number formats.
     */
    protected static $formats = [
        '+354 ### ####',
        '+354 #######',
        '+354#######',
        '### ####',
        '#######',
    ];
}
