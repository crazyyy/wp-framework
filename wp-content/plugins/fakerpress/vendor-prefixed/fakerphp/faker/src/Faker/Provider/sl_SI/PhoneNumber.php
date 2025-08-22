<?php

namespace FakerPress\ThirdParty\Faker\Provider\sl_SI;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '+386 ## ### ###',
        '00386 ## ### ###',
        '0## ### ###',
        '00386########',
        '+386########',
        '0########',
        '+386 # ### ####',
        '00386 # ### ####',
        '0# ### ####',
    ];
}
