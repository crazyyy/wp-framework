<?php

namespace FakerPress\ThirdParty\Faker\Provider\ru_RU;

class PhoneNumber extends \FakerPress\ThirdParty\Faker\Provider\PhoneNumber
{
    protected static $formats = [
        '(812) ###-##-##',
        '(495) ###-####',
        '+7 (922) ###-####',
        '(35222) ##-####',
        '8-800-###-####',
    ];
}
