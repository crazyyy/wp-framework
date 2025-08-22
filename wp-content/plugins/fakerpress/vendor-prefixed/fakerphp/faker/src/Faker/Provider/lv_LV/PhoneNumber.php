<?php

namespace FakerPress\ThirdParty\Faker\Provider\lv_LV;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    /**
     * {@link} https://en.wikipedia.org/wiki/Telephone_numbers_in_Latvia
     */
    protected static $formats = [
        '########',
        '## ### ###',
        '+371 ########',
    ];
}
