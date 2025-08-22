<?php

namespace FakerPress\ThirdParty\Faker\Provider\cs_CZ;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '+420 %## ### ###',
        '%## ### ###',
        '00420%########',
        '+420%########',
        '%########',
    ];
}
